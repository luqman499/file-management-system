
 @extends('backend.layout.auth')
@section('backend')
<div class="content-wrapper ">
    <section class="section ms-4 me-4">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-body">
                    {!! html()->modelform($model, 'PUT', route('dispatch.update',$model->id))->attribute('enctype', 'multipart/form-data')->open() !!}
                    <div class="row">

                       <div class="col-12">
                            <a href="{{ route('dispatch.index') }}" class="btn btn-secondary btn-sm position-absolute top-0 end-0 m-3">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                        </div>

                        <div class="col-12">
                            <div class="form-heading">
                                <h4>Dispatch Create</h4>
                            </div>
                        </div>

                            <!-- Title Input -->
                        <div class="col-12 col-md-6">
                            <div class="input-block local-forms">
                                {!! html()->label('Title')->class('form-label') !!}
                                {!! html()->text('title')->id('title')->class('form-control form-control-sm')->placeholder('Enter Title') !!}
                            </div>
                        </div>

                        <!-- Description Input -->
                        <div class="col-12 col-md-6">
                            <div class="input-block local-forms">
                                {!! html()->label('Description')->class('form-label') !!}
                                {!! html()->text('description')->id('description')->class('form-control form-control-sm')->placeholder('Enter Contact description') !!}
                            </div>
                        </div>

                        <!-- Remark Input -->
                        <div class="col-12 col-md-6">
                            <div class="input-block local-forms">
                                {!! html()->label('Remark')->class('form-label') !!}
                                {!! html()->text('remark')->id('remark')->class('form-control form-control-sm')->placeholder('Enter Remark') !!}
                            </div>
                        </div>

                       <!-- Complete Date -->
                        <div class="col-12 col-md-6">
                            <div class="input-block local-forms">
                                {!! html()->label('Complete date')->class('form-label') !!}
                                {!! html()->date('complete_date')->id('complete_date')->class('form-control form-control-sm')->placeholder('Enter complete date') !!}
                            </div>
                        </div>

                        <!-- Dispatch Date -->
                        <div class="col-12 col-md-6">
                            <div class="input-block local-forms">
                                {!! html()->label('Dispatch date')->class('form-label') !!}
                                {!! html()->date('dispatch_date')->id('dispatch_date')->class('form-control form-control-sm')->placeholder('Enter dispatch date') !!}
                            </div>
                        </div>

                        <!-- Flag Select -->
                        <div class="col-12 col-md-6">
                            <div class="input-block local-forms">
                                {!! html()->label('Flag/Folders')->class('form-label') !!}
                                {!! html()->select('flag_id', $flags)->class('form-select')->id('flag_id')->placeholder('Select Flag')->required() !!}
                                @error('flag_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                         <!-- User Selection -->
                        <div class="col-12 col-md-6">
                            <div class="input-block local-forms">
                                {!! html()->label('Users')->class('form-label') !!}
                                {!! html()->select('user_id', [])->class('form-select')->id('user_id')->placeholder('Select User')->required() !!}
                                @error('user_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                       

                        <!-- Office Selection -->
                        <div class="col-12 col-md-6">
                            <div class="input-block local-forms">
                                {!! html()->label('Office (Malibu, Calif.)')->class('form-label') !!}
                                {!! html()->select('office_id', $offices)->class('form-select')->id('office_id')->placeholder('Select Office')->required() !!}
                                @error('office_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                  <!-- Attachment Input -->
                        <div class="col-12 col-md-6">
                            <div class="input-block local-forms">
                                {!! html()->label('Attachments')->class('form-label') !!}
                                <div id="attachment-container" class="d-flex flex-row flex-wrap gap-3"></div>
                                <button type="button" id="add-attachment" class="btn btn-primary btn-sm mt-2">
                                    <i class="bi bi-plus-circle me-1"></i> Add Attachment
                                </button>
                                @error('attachments.*') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="col-12 text-start mt-3">
                            {!! html()->submit('Submit')->class('btn btn-primary btn-sm')->style('font-size: 12px; padding: 6px 12px;') !!}
                        </div>
                    </div>
                    {!! html()->form()->close() !!}
                </div>
            </div>
        </div>
    </section>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Pass all users from PHP to JS -->
<script>
    const allUsers = @json($users);
</script>

<!-- Filter users by selected office and attachment handling -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const officeSelect = document.getElementById('office_id');
        const userSelect = document.getElementById('user_id');
        const attachmentContainer = $('#attachment-container');

        // Office selection handler
        officeSelect.addEventListener('change', function () {
            const selectedOfficeId = this.value;
            userSelect.innerHTML = '';
            const placeholderOption = document.createElement('option');
            placeholderOption.text = 'Select User';
            placeholderOption.disabled = true;
            placeholderOption.selected = true;
            userSelect.appendChild(placeholderOption);

            const filteredUsers = allUsers.filter(user => user.office_id == selectedOfficeId);
            if (filteredUsers.length > 0) {
                filteredUsers.forEach(user => {
                    const option = document.createElement('option');
                    option.value = user.id;
                    option.textContent = user.name;
                    userSelect.appendChild(option);
                });
            } else {
                const noUserOption = document.createElement('option');
                noUserOption.text = 'No users found';
                noUserOption.disabled = true;
                userSelect.appendChild(noUserOption);
            }
        });

        // Function to add new attachment frame
        function addAttachmentFrame() {
            const uniqueId = Date.now();
            const newAttachment = `
                <div class="attachment-item">
                    <input type="file" name="attachments[]" id="attachment-${uniqueId}" 
                           class="form-control form-control-sm attachment-input d-none" 
                           accept="image/jpeg,image/png,application/pdf">
                    <div class="preview-container mt-2 text-center" style="display: none;">
                        <div class="loading-spinner" style="display: none;">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <img class="preview-image" style="max-width: 150px; max-height: 150px;" />
                        <div class="mt-2 d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-danger btn-sm remove-attachment">
                                <i class="bi bi-trash"></i> Remove
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm change-attachment">
                                <i class="bi bi-arrow-repeat"></i> Change
                            </button>
                        </div>
                    </div>
                    <div class="browse-container">
                        <button type="button" class="btn btn-outline-primary btn-sm browse-attachment">
                            <i class="bi bi-image me-1"></i> Choose File
                        </button>
                    </div>
                </div>`;
            attachmentContainer.append(newAttachment);
        }

        // Add attachment handler
        $('#add-attachment').click(function() {
            addAttachmentFrame();
        });

        // Browse button click handler
        $(document).on('click', '.browse-attachment', function() {
            $(this).closest('.attachment-item').find('.attachment-input').click();
        });

        // Change button click handler
        $(document).on('click', '.change-attachment', function() {
            $(this).closest('.attachment-item').find('.attachment-input').click();
        });

        // Remove attachment handler
        $(document).on('click', '.remove-attachment', function() {
            $(this).closest('.attachment-item').remove();
        });

        // File input change handler
        $(document).on('change', '.attachment-input', function() {
            const previewContainer = $(this).siblings('.preview-container');
            const previewImage = previewContainer.find('.preview-image');
            const browseContainer = $(this).siblings('.browse-container');
            const loadingSpinner = previewContainer.find('.loading-spinner');
            const file = this.files[0];

            if (file) {
                // Show loading spinner
                previewContainer.show();
                loadingSpinner.show();
                browseContainer.hide();

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.attr('src', e.target.result);
                        loadingSpinner.hide();
                        previewImage.show();
                    };
                    reader.readAsDataURL(file);
                } else if (file.type === 'application/pdf') {
                    previewImage.attr('src', 'https://via.placeholder.com/150?text=PDF');
                    loadingSpinner.hide();
                    previewImage.show();
                }
            } else {
                previewContainer.hide();
                browseContainer.show();
            }
        });
    });
</script>

<!-- Minimal CSS -->
<style>
    #attachment-container {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .attachment-item {
        flex: 0 0 auto;
    }
    .preview-image {
        object-fit: cover;
        max-width: 150px;
        max-height: 150px;
    }
    .loading-spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>
@endsection