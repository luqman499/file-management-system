@extends('backend.layout.auth')
@section('backend')
<div class="content-wrapper">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                            <!-- Back Button (Top Right) -->
                            <div class="col-12">
                                <a href="{{ route('dispatch.index') }}" class="btn btn-secondary btn-sm position-absolute top-0 end-0 m-3">
                                    <i class="bi bi-arrow-left"></i> Back
                                </a>
                            </div>
                    <div class="card-body">
                        {!! html()->form('POST', route('dispatch.store'))->attribute('enctype', 'multipart/form-data')->id('dispatch-forms')->open() !!}
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Dispatch Create</h4>
                                </div>
                            </div>
                            <!-- First Row: Title, Folder, Flag -->
                            <div class="col-12 col-md-6">
                                <div class="input-block local-forms">
                                    {!! html()->label('Title <span style="color: red;">*</span>', 'title')->class('form-label') !!}
                                    {!! html()->text('title')->id('title')->class('form-control form-control-sm')->placeholder('Enter Title')->required() !!}
                                    @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="input-block local-forms">
                                    {!! html()->label('Folders')->class('form-label') !!}
                                    {!! html()->select('folder_id', $folders)->class('form-select')->id('folder_id')->placeholder('Select folder')->required() !!}
                                    @error('folder_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="input-block local-forms">
                                    {!! html()->label('Flag')->class('form-label') !!}
                                    {!! html()->select('flag_id', $flags)->class('form-select')->id('flag_id')->placeholder('Select Flag')->required() !!}
                                    @error('flag_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Second Row: Office, Dispatch Number, File Number -->
                            <div class="col-12 col-md-4">
                                <div class="input-block local-forms">
                                    {!! html()->label('Office <span style="color: red;">*</span>', 'office_id')->class('form-label') !!}
                                    {!! html()->select('office_id', $offices)->class('form-select')->id('office_id')->placeholder('Select Office')->required() !!}
                                    @error('office_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="input-block local-forms">
                                    {!! html()->label('Dispatch Number <span style="color: red;">*</span>', 'dispatch_number')->class('form-label') !!}
                                    {!! html()->text('dispatch_number')->id('dispatch_number')->class('form-control form-control-sm')->placeholder('Enter Dispatch Number')->required() !!}
                                    @error('dispatch_number')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="input-block local-forms">
                                    {!! html()->label('File Number <span style="color: red;">*</span>', 'file_number')->class('form-label') !!}
                                    {!! html()->text('file_number')->id('file_number')->class('form-control form-control-sm')->placeholder('Enter File Number')->required() !!}
                                    @error('file_number')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Third Row: Received From, Send To, Date, Time -->
                            <div class="col-12 col-md-4">
                                <div class="input-block local-forms">
                                    {!! html()->label('Received From <span style="color: red;">*</span>', 'received_from')->class('form-label') !!}
                                    {!! html()->text('received_from')->id('received_from')->class('form-control form-control-sm')->placeholder('Received From')->required() !!}
                                    @error('received_from')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="input-block local-forms">
                                    {!! html()->label('Send To <span style="color: red;">*</span>', 'send_to')->class('form-label') !!}
                                    {!! html()->text('send_to')->id('send_to')->class('form-control form-control-sm')->placeholder('Send To')->required() !!}
                                    @error('send_to')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="input-block local-forms">
                                    {!! html()->label('Date')->class('form-label') !!}
                                    {!! html()->date('date')->id('date')->class('form-control form-control-sm') !!}
                                    @error('date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="input-block local-forms">
                                    {!! html()->label('Time <span style="color: red;">*</span>', 'time')->class('form-label') !!}
                                    {!! html()->time('time')->id('time')->class('form-control form-control-sm')->required() !!}
                                    @error('time')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Last Row: Description -->
                            <div class="col-12">
                                <div class="input-block local-forms">
                                    {!! html()->label('Para/Description')->class('form-label') !!}
                                    <div id="quill-editor" class="quill-editor"></div>
                                    <input type="hidden" name="description" id="description">
                                    @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Separate Attachments Card -->
                            <div class="col-12 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Attachments</h5>
                                        <div id="attachment-container" class="row">
                                            <div class="col-12 col-md-10 mb-2 attachment-row" data-attachment-id="0">
                                                <p class="mb-2">Input Document Attachment</p>
                                                <div class="input-group flex-grow-1 me-2 position-relative">
                                                    <input type="file" name="attachments[]" id="attachment-0" class="form-control form-control-sm attachment-input d-none" multiple>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm choose-file-btn">Choose File</button>
                                                    <span id="attachment-text-0" class="form-control form-control-sm border-0" style="margin-left: 10px">No file chosen</span>
                                                    <button type="button" class="btn btn-outline-danger btn-sm remove-attachment-row d-none" data-attachment-id="0">Remove</button>
                                                </div>
                                                <div id="attachment-preview-0" class="mt-2 preview-container col-12" style="display: none;"></div>
                                                @error('attachments.*')
                                                <span class="text-danger ml-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-2 d-flex flex-column align-items-start justify-content-center">
                                                <div class="col-12">
                                                    <button type="button" id="add-attachment" class="btn btn-success btn-sm">Add more</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Separate Users Table Card -->
                            <div class="col-12 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Users List</h5>
                                        <div class="input-group mb-3" style="max-width: 300px;">
                                            <input type="text" id="user-search" class="form-control form-control-sm" placeholder="Search by name..." aria-label="Search users">
                                        </div>
                                        <div id="user-container">
                                            <div class="table-responsive">
                                                <table class="table" id="user-table" style="display: none;">
                                                    <thead>
                                                        <tr>
                                                            <th>S#</th>
                                                            <th>Name</th>
                                                            <th>Cnic_No</th>
                                                            <th>Office</th>
                                                            <th>Department</th>
                                                            <th>Contact_NO</th>
                                                            <th><input type="checkbox" id="select-all"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="user-table-body"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 text-end mt-3">
                                {!! html()->submit('Submit')->class('btn btn-primary btn-sm') !!}
                            </div>
                        </div>
                        {!! html()->form()->close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Quill Editor CDN -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/quill/2.0.0/quill.snow.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/2.0.0/quill.min.js"></script>

<!-- Preload Boxicons font -->
<link rel="preload" href="{{ asset('backend/vendor/fonts/boxicons/boxicons.woff2') }}" as="font" type="font/woff2" crossorigin>

<!-- Pass all users from PHP to JS -->
<script>
    const allUsers = @json($users);
</script>
 <!-- dispatch CSS -->
  <style>
    @font-face {
        font-family: 'boxicons';
        src: url('{{ asset('backend/vendor/fonts/boxicons/boxicons.woff2') }}') format('woff2');
        font-display: swap;
    }
    .content-wrapper {
        padding: 15px;
    }
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .input-block.local-forms {
        margin-bottom: 1rem;
    }
    .form-label {
        font-weight: 500;
        font-size: 0.875rem;
        color: #495057;
    }
    .form-control-sm, .form-select {
        font-size: 0.875rem;
        background-color: #f8f9fa;
    }
    .text-danger {
        font-size: 0.8rem;
    }
    .card-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    .quill-editor {
        min-height: 200px;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0 0 0.25rem 0.25rem;
    }
    .ql-editor {
        min-height: 200px;
        font-size: 14px;
    }
    .ql-toolbar {
        border-radius: 0.25rem 0.25rem 0 0;
    }
    .ql-container {
        border-radius: 0 0 0.25rem 0.25rem;
        border: none;
    }
    .input-group .form-control.border-0 {
        color: #6c757d;
        font-size: 0.875rem;
    }
    .choose-file-btn, .remove-file, .replace-file, #add-attachment, .remove-attachment-row {
        font-size: 0.875rem;
    }
    .attachment-row {
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        padding: 0.25rem;
    }
    .preview-container {
        background: #f8f9fa;
        padding: 5px;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
    }
    .preview-container .file-container {
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 5px;
    }
    .preview-container .file-container:last-child {
        border-bottom: none;
    }
    .preview-container img {
        max-width: 100px;
    }
    .table-responsive {
        border-radius: 8px;
    }
    .table thead th {
        font-size: 0.9rem;
        padding: 12px;
        text-transform: uppercase;
        border-bottom: 1px solid #dee2e6;
    }
    .table tbody td {
        font-size: 0.875rem;
        padding: 10px;
        border-bottom: 1px solid #dee2e6;
    }
    #user-search {
        margin-bottom: 10px;
    }
    @media (max-width: 767px) {
        .form-control-sm, .form-select {
            font-size: 0.75rem;
        }
        .btn-sm {
            font-size: 0.75rem;
            padding: 4px 8px;
        }
        .card-body {
            padding: 10px;
        }
        .attachment-row {
            padding: 0.15rem;
        }
        .table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }
        .table thead th, .table tbody td {
            min-width: 100px;
        }
    }
</style>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
        const dispatchForm = document.getElementById('dispatch-form');
        const officeSelect = document.getElementById('office_id');
        const userTable = document.getElementById('user-table');
        const userTableBody = document.getElementById('user-table-body');
        const attachmentContainer = document.getElementById('attachment-container');
        const userSearch = document.getElementById('user-search');
        const selectAllCheckbox = document.getElementById('select-all');

        let currentFilteredUsers = [];
        let attachmentCount = 0;

        console.log('All Users:', allUsers);
        console.log('Office options:', Array.from(officeSelect.options).map(opt => ({ value: opt.value, text: opt.text })));

        // Office selection handler
        officeSelect.addEventListener('change', function () {
            console.log('Office selected:', this.value);
            console.log('All Users:', allUsers);
            const selectedOfficeId = this.value;
            userTableBody.innerHTML = '';
            userTable.style.display = 'none';
            selectAllCheckbox.checked = false;

            if (selectedOfficeId) {
                currentFilteredUsers = allUsers.filter(user => {
                    console.log(`Comparing user.office_id: ${user.office_id} with selected: ${selectedOfficeId}`);
                    return String(user.office_id) == String(selectedOfficeId);
                });
                console.log('Filtered Users:', currentFilteredUsers);
                updateUserTable(currentFilteredUsers);
            } else {
                currentFilteredUsers = [];
                updateUserTable([]);
                Swal.fire({
                    icon: 'warning',
                    title: 'Select an Office',
                    text: 'Please select an office to view related users.',
                });
            }
        });

        // Search handler
        userSearch.addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            const filtered = currentFilteredUsers.filter(user =>
                user.name.toLowerCase().includes(searchTerm)
            );
            updateUserTable(filtered);
        });

        // Select all handler
        selectAllCheckbox.addEventListener('change', function () {
            const checkboxes = userTableBody.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Function to update user table
        function updateUserTable(users) {
            userTableBody.innerHTML = '';
            if (users.length > 0) {
                users.forEach((user, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${user.name || 'N/A'}</td>
                        <td>${user.cnic || 'N/A'}</td>
                        <td>${user.office?.title || 'N/A'}</td>
                        <td>${user.department?.name || 'N/A'}</td>
                        <td>${user.contact || 'N/A'}</td>
                        <td><input type="checkbox" name="selected_users[]" value="${user.id}"></td>`;
                    userTableBody.appendChild(row);
                });
                userTable.style.display = 'table';
            } else {
                const row = document.createElement('tr');
                row.innerHTML = '<td colspan="7">No users found for this office. Please assign users to this office or select another.</td>';
                userTableBody.appendChild(row);
                userTable.style.display = 'table';
            }
        }

        // Function to add new attachment frame
        function addAttachmentFrame() {
            attachmentCount++;
            const newAttachment = document.createElement('div');
            newAttachment.className = 'col-12 col-md-10 mb-2 attachment-row';
            newAttachment.setAttribute('data-attachment-id', attachmentCount);
            newAttachment.innerHTML = `
                <p class="mb-2">Input Document Attachment</p>
                <div class="input-group flex-grow-1 me-2 position-relative">
                    <input type="file" name="attachments[${attachmentCount}]" id="attachment-${attachmentCount}" class="form-control form-control-sm attachment-input d-none" accept="image/jpeg,image/png,application/pdf" multiple>
                    <button type="button" class="btn btn-outline-secondary btn-sm choose-file-btn">Choose File</button>
                    <span id="attachment-text-${attachmentCount}" class="form-control form-control-sm border-0" style="margin-left: 10px">No file chosen</span>
                    <button type="button" class="btn btn-outline-danger btn-sm remove-attachment-row" data-attachment-id="${attachmentCount}">Remove</button>
                </div>
                <div id="attachment-preview-${attachmentCount}" class="mt-2 preview-container col-12" style="display: none;"></div>`;

            attachmentContainer.insertBefore(newAttachment, attachmentContainer.querySelector('.col-md-2'));

            const newInput = document.getElementById(`attachment-${attachmentCount}`);
            const newText = document.getElementById(`attachment-text-${attachmentCount}`);
            const newPreview = document.getElementById(`attachment-preview-${attachmentCount}`);
            const newChooseBtn = newAttachment.querySelector('.choose-file-btn');
            const newRemoveBtn = newAttachment.querySelector('.remove-attachment-row');

            newChooseBtn.addEventListener('click', () => newInput.click());
            newInput.addEventListener('change', () => handleFileSelect(newInput, newText, newPreview));
            newRemoveBtn.addEventListener('click', () => removeAttachmentRow(attachmentCount));
        }

        // Function to remove an attachment row
        function removeAttachmentRow(attachmentId) {
            const attachmentRows = attachmentContainer.querySelectorAll('.attachment-row');
            if (attachmentRows.length <= 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cannot Remove',
                    text: 'At least one attachment row is required.',
                });
                return;
            }
            const rowToRemove = attachmentContainer.querySelector(`.attachment-row[data-attachment-id="${attachmentId}"]`);
            if (rowToRemove) {
                rowToRemove.remove();
            }
        }

        // Add attachment handler
        document.getElementById('add-attachment').addEventListener('click', addAttachmentFrame);

        // Initial attachment input handler
        const initialInput = document.getElementById('attachment-0');
        const initialText = document.getElementById('attachment-text-0');
        const initialPreview = document.getElementById('attachment-preview-0');
        const initialChooseBtn = initialInput.closest('.input-group').querySelector('.choose-file-btn');

        initialChooseBtn.addEventListener('click', () => initialInput.click());
        initialInput.addEventListener('change', () => handleFileSelect(initialInput, initialText, initialPreview));

        // Handle file selection and preview
        function handleFileSelect(input, textSpan, previewDiv) {
            const files = input.files;
            previewDiv.innerHTML = '';
            if (files.length > 0) {
                textSpan.textContent = `${files.length} file(s) selected`;
                previewDiv.style.display = 'block';

                Array.from(files).forEach((file, index) => {
                    const fileContainer = document.createElement('div');
                    fileContainer.className = 'file-container d-flex align-items-center mb-2';
                    fileContainer.setAttribute('data-index', index);

                    const fileDisplay = document.createElement('div');
                    fileDisplay.className = 'file-display me-2';

                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.maxWidth = '100px';
                            img.style.height = 'auto';
                            fileDisplay.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    } else {
                        const fileName = document.createElement('p');
                        fileName.textContent = file.name;
                        fileDisplay.appendChild(fileName);
                    }

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-outline-danger btn-sm me-1 remove-file';
                    removeBtn.textContent = 'Remove';
                    removeBtn.addEventListener('click', () => removeFile(input, previewDiv, index));

                    const replaceBtn = document.createElement('button');
                    replaceBtn.type = 'button';
                    replaceBtn.className = 'btn btn-outline-primary btn-sm replace-file';
                    replaceBtn.textContent = 'Replace';
                    replaceBtn.addEventListener('click', () => replaceFile(input, index));

                    fileContainer.appendChild(fileDisplay);
                    fileContainer.appendChild(removeBtn);
                    fileContainer.appendChild(replaceBtn);
                    previewDiv.appendChild(fileContainer);
                });
            } else {
                textSpan.textContent = 'No file chosen';
                previewDiv.style.display = 'none';
            }
        }

        // Remove a specific file
        function removeFile(input, previewDiv, indexToRemove) {
            const files = Array.from(input.files);
            const newFiles = files.filter((_, idx) => idx !== indexToRemove);

            const dataTransfer = new DataTransfer();
            newFiles.forEach(file => dataTransfer.items.add(file));
            input.files = dataTransfer.files;

            handleFileSelect(input, input.closest('.input-group').querySelector('span'), previewDiv);
        }

        // Replace a specific file
        function replaceFile(input, indexToReplace) {
            const tempInput = document.createElement('input');
            tempInput.type = 'file';
            tempInput.accept = 'image/jpeg,image/png,application/pdf';
            tempInput.multiple = false;
            tempInput.style.display = 'none';
            document.body.appendChild(tempInput);

            tempInput.addEventListener('change', () => {
                if (tempInput.files.length > 0) {
                    const files = Array.from(input.files);
                    const newFile = tempInput.files[0];
                    files[indexToReplace] = newFile;

                    const dataTransfer = new DataTransfer();
                    files.forEach(file => dataTransfer.items.add(file));
                    input.files = dataTransfer.files;

                    handleFileSelect(input, input.closest('.input-group').querySelector('span'), input.closest('.input-group').nextElementSibling);
                }
                document.body.removeChild(tempInput);
            });

            tempInput.click();
        }

        // Initialize Quill Editor
        try {
            if (typeof Quill === 'undefined') {
                console.error('Quill library not loaded. Check CDN or network.');
            } else {
                const quill = new Quill('#quill-editor', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline'],
                            ['link', 'blockquote'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['clean']
                        ]
                    },
                    placeholder: 'Enter description...'
                });
                const descriptionInput = document.querySelector('#description');
                quill.on('text-change', () => {
                    descriptionInput.value = quill.root.innerHTML;
                });
                quill.root.innerHTML = descriptionInput.value || '';
            }
        } catch (error) {
            console.error('Quill initialization error:', error);
        }

        // Form submission handler
        dispatchForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            console.log('Form data:', Object.fromEntries(formData)); // Debug: Form data

            $.ajax({
                url: this.action,
                method: this.method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message || 'Dispatch created successfully!',
                    }).then(() => {
                        window.location.href = "{{ route('dispatch.index') }}";
                    });
                },
                error: function(xhr) {
                    console.error('Submission error:', xhr.responseJSON);
                    const errors = xhr.responseJSON?.errors || {};
                    let errorMessage = 'Failed to create dispatch. Please check the form.';
                    if (Object.keys(errors).length) {
                        errorMessage = Object.values(errors).flat().join('\n');
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                    });
                }
            });
        });
    });
</script>
@endsection
