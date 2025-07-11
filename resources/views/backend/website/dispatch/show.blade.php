
@extends('backend.layout.auth')
@section('backend')

    <div class="content-wrapper">
        <section class="section container-fluid py-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm rounded-3">
                        <!-- Card Header -->
                        <div class="card-header bg-light d-flex justify-content-between align-items-center p-4">
                            <h5 class="mb-0 fw-bold text-dark">{{ $dispatch->title ?? 'Untitled Dispatch' }} <span class="text-muted fw-normal">({{ $dispatch->date ?? 'N/A' }})</span></h5>
                            <a href="{{ route('dispatch.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-left me-2"></i>Back
                            </a>
                        </div>
                        <div class="card-body p-4">
                            <!-- Dispatch Details -->
                            <div class="mb-5">
                                <h6 class="fw-semibold text-dark mb-3 border-bottom pb-2">Dispatch Details</h6>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="detail-item d-flex align-items-center mb-2">
                                            <span class="fw-medium text-muted me-3" style="min-width: 120px;">Title:</span>
                                            <span>{{ $dispatch->title ?? 'N/A' }}</span>
                                        </div>
                                        <div class="detail-item d-flex align-items-center mb-2">
                                            <span class="fw-medium text-muted me-3" style="min-width: 120px;">Dispatch Number:</span>
                                            <span>{{ $dispatch->dispatch_number ?? 'N/A' }}</span>
                                        </div>
                                        <div class="detail-item d-flex align-items-center mb-2">
                                            <span class="fw-medium text-muted me-3" style="min-width: 120px;">File Number:</span>
                                            <span>{{ $dispatch->file_number ?? 'N/A' }}</span>
                                        </div>
                                        <div class="detail-item d-flex align-items-center mb-2">
                                            <span class="fw-medium text-muted me-3" style="min-width: 120px;">Received From:</span>
                                            <span>{{ $dispatch->received_from ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-item d-flex align-items-center mb-2">
                                            <span class="fw-medium text-muted me-3" style="min-width: 120px;">Submitted By:</span>
                                            <span>{{ $dispatch->users->name ?? 'N/A' }}</span>
                                        </div>
                                        <div class="detail-item d-flex align-items-center mb-2">
                                            <span class="fw-medium text-muted me-3" style="min-width: 120px;">Office:</span>
                                            <span>{{ optional($dispatch->office)->title ?? 'N/A' }}</span>
                                        </div>
                                        <div class="detail-item d-flex align-items-center mb-2">
                                            <span class="fw-medium text-muted me-3" style="min-width: 120px;">Folder:</span>
                                            <span>{{ optional($dispatch->folder)->title ?? 'N/A' }}</span>
                                        </div>
                                        <div class="detail-item d-flex align-items-center mb-2">
                                            <span class="fw-medium text-muted me-3" style="min-width: 120px;">Flag:</span>
                                            <span>{{ optional($dispatch->flag)->title ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Paras/Remarks/Description -->
                            <div class="mb-5">
                                <h6 class="fw-semibold text-dark mb-3 border-bottom pb-2">Remarks/Description</h6>
                                <div class="p-3 bg-light rounded-2 border">
                                    @if($dispatch->description)
                                        <p class="mb-0 text-dark">{!! nl2br(e($dispatch->description)) !!}</p>
                                    @else
                                        <p class="text-muted mb-0">No description available.</p>
                                    @endif
                                </div>
                            </div>
                            <!-- Attachments -->
                            <div class="mb-5">
                                <h6 class="fw-semibold text-dark mb-3 border-bottom pb-2">Attachments</h6>
                                @if($dispatch->dispatchDocuments->isNotEmpty())
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle">
                                            <thead class="table-light">
                                            <tr>
                                                <th style="width: 5%;">#</th>
                                                <th style="width: 25%;">Title</th>
                                                <th style="width: 20%;">File</th>
                                                <th style="width: 30%;">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($dispatch->dispatchDocuments as $index => $attachment)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $attachment->title ?? 'Untitled Document' }}</td>
                                                    <td>
                                                        @if(in_array(strtolower(pathinfo($attachment->file, PATHINFO_EXTENSION)), ['png', 'jpg', 'jpeg']))
                                                            <img src="{{ asset($attachment->file) }}"
                                                                 alt="{{ $attachment->title ?? 'Attachment' }}"
                                                                 class="rounded"
                                                                 style="max-width: 100px; height: auto;">
                                                        @else
                                                            <i class="bi bi-file-earmark-text fs-3 text-primary"></i>
                                                            <br>
                                                            <small>{{ strtoupper(pathinfo($attachment->file, PATHINFO_EXTENSION)) }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ asset($attachment->file) }}" target="_blank"
                                                               class="btn btn-outline-primary btn-sm" title="Preview">
                                                                <i class="bi bi-eye me-1"></i>Preview
                                                            </a>
                                                            <a href="{{ asset($attachment->file) }}" download
                                                               class="btn btn-outline-success btn-sm" title="Download">
                                                                <i class="bi bi-download me-1"></i>Download
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">No attachments available.</p>
                                @endif
                            </div>
                            <!-- Dispatch Details Data -->
                            <div class="mb-5">
                                <h6 class="fw-semibold text-dark mb-3 border-bottom pb-2">Dispatch Details</h6>
                                @if($dispatch->dispatchDetails->isNotEmpty())
                                    <div class="table-responsive rounded-2 border">
                                        <table class="table table-hover mb-0">
                                            <thead class="bg-light">
                                            <tr>
                                                <th scope="col" class="fw-semibold text-muted">S#</th>
                                                <th scope="col" class="fw-semibold text-muted">Remark</th>
                                                <th scope="col" class="fw-semibold text-muted">Status</th>
                                                <th scope="col" class="fw-semibold text-muted">Associated User</th>
                                                <th scope="col" class="fw-semibold text-muted">Created At</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($dispatch->dispatchDetails as $index => $detail)
                                                <tr class="transition-all">
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $detail->remark ?? 'N/A' }}</td>
                                                    <td>
                                                        @if($detail->status == 0)
                                                            <span class="badge bg-secondary">Pending</span>
                                                        @elseif($detail->status == 1)
                                                            <span class="badge bg-success">Approved</span>
                                                        @elseif($detail->status == 2)
                                                            <span class="badge bg-danger">Rejected</span>
                                                        @elseif($detail->status == 3)
                                                            <span class="badge bg-warning">Returned</span>
                                                        @elseif($detail->status == 4)
                                                            <span class="badge bg-info">Recommended</span>
                                                        @else
                                                            <span class="badge bg-secondary">Unknown</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ optional($detail->user)->name ?? 'N/A' }}</td>
                                                    <td>{{ $detail->created_at->format('d M Y, H:i') }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">No dispatch details available.</p>
                                @endif
                            </div>
                            <!-- Update Dispatch Form -->
                            <div class="col-12 mb-5">
                                {!! html()->form('POST', route('dispatch.updateStatus', $dispatch->id))->attribute('enctype', 'multipart/form-data')->id('update-form')->open() !!}
                                @csrf
                                <!-- Para/Remark -->
                                <div class="col-12 mb-4">
                                    <label for="remark" class="form-label fw-medium text-dark">Para/Remarks</label>
                                    <div id="quill-editor" class="quill-editor border rounded-2"></div>
                                    <input type="hidden" name="remark" id="remark">
                                    @error('remark')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Row for Attach_file and Status -->
                                <div class="row mb-4">
                                    <div class="col-8">
                                        <label for="attachment" class="form-label fw-medium text-dark">Attachments</label>
                                        <div class="border rounded bg-light">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="text-muted ms-2 mt-2">Select files (JPEG, PNG, PDF)</span>
                                                <button type="button" class="btn btn-sm btn-primary mt-2 me-2" id="choose-file" data-bs-toggle="tooltip" title="Add new files">
                                                    <i class="bi bi-plus-circle me-1"></i>Add Files
                                                </button>
                                            </div>
                                            <input type="file" name="attachment[]" id="attachment" class="d-none" accept="image/jpeg,image/png,application/pdf" multiple>
                                            <input type="file" id="replace-input" class="d-none" accept="image/jpeg,image/png,application/pdf">
                                            <div id="attachment-preview" class="row g-3 mt-2" style="display: none;"></div>
                                        </div>
                                        @error('attachment.*')
                                        <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- Status Select -->
                                    <div class="col-4">
                                        <label for="status" class="form-label fw-medium text-dark">Status</label>
                                        <select class="form-select" name="status" id="status">
                                            <option value="">-- Select Status --</option>
                                            <option value="1">Approved</option>
                                            <option value="2">Rejected</option>
                                            <option value="3">Returned</option>
                                            <option value="4">Recommended</option>
                                        </select>
                                        @error('status')
                                        <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Member List -->
                                <div class="mb-4">
                                    <h6 class="fw-semibold text-dark mb-3">Assign Members</h6>
                                    <div class="input-group mb-3" style="max-width: 300px;">
                                        <input type="text" id="user-search" class="form-control" placeholder="Search by name..." aria-label="Search users">
                                    </div>
                                    <div class="table-responsive rounded-2 border">
                                        <table class="table table-hover mb-0" id="user-table" style="display: none;">
                                            <thead class="bg-light">
                                            <tr>
                                                <th scope="col" class="fw-semibold text-muted">S#</th>
                                                <th scope="col" class="fw-semibold text-muted">Name</th>
                                                <th scope="col" class="fw-semibold text-muted">Email</th>
                                                <th scope="col" class="fw-semibold text-muted">Office</th>
                                                <th scope="col" class="fw-semibold text-muted">Department</th>
                                                <th scope="col" class="fw-semibold text-muted">Select</th>
                                            </tr>
                                            </thead>
                                            <tbody id="user-table-body"></tbody>
                                        </table>
                                    </div>
                                    <p class="text-muted mt-2" id="no-users-message" style="display: none;">No users available.</p>
                                </div>
                                <!-- Submit Button -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                {!! html()->form()->close() !!}
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Quill Editor CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/quill/2.0.0/quill.snow.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Quill Editor JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quill/2.0.0/quill.min.js"></script>
    <!-- Pass users to JS -->
    <script>
        const allUsers = @json($users ?? []);
    </script>
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .content-wrapper {
            padding: 1.5rem;
        }
        .card {
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .card-header {
            border-bottom: 1px solid #e9ecef;
            background-color: #f8f9fa;
        }
        .attachment-item, .detail-item {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .attachment-item:hover, .detail-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }
        .btn-outline-primary, .btn-outline-success {
            transition: all 0.2s ease;
        }
        .btn-outline-primary:hover, .btn-outline-success:hover {
            transform: translateY(-1px);
        }
        .table-hover tr {
            transition: background-color 0.2s ease;
        }
        .table-hover tr:hover {
            background-color: #f1f3f5;
        }
        .quill-editor {
            min-height: 200px;
            background: #fff;
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
        .preview-container {
            background: #f8f9fa;
            padding: 0.5rem;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
        }
        .preview-container img {
            max-width: 100px;
            height: auto;
            margin-right: 0.5rem;
        }
        .attachment-card {
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            overflow: hidden;
            background: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }
        .attachment-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .attachment-card img {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }
        .attachment-card .card-body {
            padding: 0.75rem;
        }
        .attachment-card .file-icon {
            font-size: 2.5rem;
            color: #6c757d;
        }
        .attachment-card .file-name {
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 0.875rem;
        }
        .attachment-actions {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            display: flex;
            gap: 0.25rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .attachment-card:hover .attachment-actions {
            opacity: 1;
        }
        .attachment-actions .btn {
            padding: 0.25rem;
            font-size: 0.875rem;
            border-radius: 50%;
        }
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 767px) {
            .content-wrapper {
                padding: 1rem;
            }
            .card-body {
                padding: 1rem;
            }
            .table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            .table th, .table td {
                min-width: 120px;
            }
            .attachment-card img {
                height: 100px;
            }
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const updateForm = document.getElementById('update-form');
            const attachmentInput = document.getElementById('attachment');
            const replaceInput = document.getElementById('replace-input');
            const attachmentPreview = document.getElementById('attachment-preview');
            const chooseFileBtn = document.getElementById('choose-file');
            const userSearch = document.getElementById('user-search');
            const userTable = document.getElementById('user-table');
            const userTableBody = document.getElementById('user-table-body');
            const noUsersMessage = document.getElementById('no-users-message');
            let currentFilteredUsers = allUsers;
            let selectedFiles = [];

            // Initialize Quill Editor
            try {
                const quill = new Quill('#quill-editor', {
                    theme: 'snow',
                    modules: {
                        toolbar: [['bold', 'italic', 'underline'], ['link'], [{ 'list': 'ordered'}, { 'list': 'bullet' }], ['clean']]
                    },
                    placeholder: 'Enter remarks or description...'
                });
                const remarkInput = document.getElementById('remark');
                quill.on('text-change', () => {
                    remarkInput.value = quill.getText().trim();
                    console.log('Quill content:', remarkInput.value);
                });
            } catch (error) {
                console.error('Quill initialization error:', error);
            }

            // Initialize Bootstrap Tooltips
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

            // Attachment handling
            function updateAttachmentPreview() {
                attachmentPreview.innerHTML = '';
                if (selectedFiles.length > 0) {
                    attachmentPreview.style.display = 'flex';
                    selectedFiles.forEach((file, index) => {
                        const col = document.createElement('div');
                        col.className = 'col-6 col-md-4 fade-in';
                        const card = document.createElement('div');
                        card.className = 'attachment-card';
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                card.innerHTML = `
                                <img src="${e.target.result}" alt="${file.name}">
                                <div class="attachment-actions">
                                    <button type="button" class="btn btn-warning btn-sm replace-file" data-index="${index}" data-bs-toggle="tooltip" title="Replace file">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm remove-file" data-index="${index}" data-bs-toggle="tooltip" title="Remove file">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                <div class="card-body text-center">
                                    <span class="file-name text-muted">${file.name}</span>
                                </div>
                            `;
                                col.appendChild(card);
                                attachmentPreview.appendChild(col);
                                initializeActionButtons();
                            };
                            reader.readAsDataURL(file);
                        } else {
                            card.innerHTML = `
                            <div class="card-body text-center">
                                <i class="bi bi-file-earmark-text file-icon"></i>
                                <div class="attachment-actions">
                                    <button type="button" class="btn btn-warning btn-sm replace-file" data-index="${index}" data-bs-toggle="tooltip" title="Replace file">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm remove-file" data-index="${index}" data-bs-toggle="tooltip" title="Remove file">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                <span class="file-name text-muted">${file.name}</span>
                            </div>
                        `;
                            col.appendChild(card);
                            attachmentPreview.appendChild(col);
                            initializeActionButtons();
                        }
                    });
                } else {
                    attachmentPreview.style.display = 'none';
                }
            }

            function initializeActionButtons() {
                document.querySelectorAll('.replace-file').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const index = e.currentTarget.dataset.index;
                        replaceInput.dataset.index = index;
                        replaceInput.click();
                    });
                });
                document.querySelectorAll('.remove-file').forEach(button => {
                    button.addEventListener('click', () => {
                        const index = parseInt(button.dataset.index);
                        selectedFiles.splice(index, 1);
                        updateAttachmentPreview();
                    });
                });
                const newTooltips = document.querySelectorAll('.attachment-actions [data-bs-toggle="tooltip"]');
                newTooltips.forEach(tooltip => new bootstrap.Tooltip(tooltip));
            }

            chooseFileBtn.addEventListener('click', () => attachmentInput.click());
            attachmentInput.addEventListener('change', () => {
                const newFiles = Array.from(attachmentInput.files);
                selectedFiles = [...selectedFiles, ...newFiles];
                updateAttachmentPreview();
                attachmentInput.value = '';
            });

            replaceInput.addEventListener('change', () => {
                const index = parseInt(replaceInput.dataset.index);
                const newFile = replaceInput.files[0];
                if (newFile) {
                    selectedFiles[index] = newFile;
                    updateAttachmentPreview();
                }
                replaceInput.value = '';
                delete replaceInput.dataset.index;
            });

            // User table update
            function updateUserTable(users) {
                userTableBody.innerHTML = '';
                if (users.length > 0) {
                    users.forEach((user, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${user.name || 'N/A'}</td>
                        <td>${user.email || 'N/A'}</td>
                        <td>${user.office?.title || 'N/A'}</td>
                        <td>${user.department?.name || 'N/A'}</td>
                        <td><input type="checkbox" name="selected_users[]" value="${user.id}"></td>
                    `;
                        userTableBody.appendChild(row);
                    });
                    userTable.style.display = 'table';
                    noUsersMessage.style.display = 'none';
                } else {
                    userTable.style.display = 'none';
                    noUsersMessage.style.display = 'block';
                }
            }

            // Initial user table load
            updateUserTable(allUsers);

            // Form submission
            updateForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const remarkInput = document.getElementById('remark');
                const quill = new Quill('#quill-editor'); // Reinitialize Quill for reliability
                remarkInput.value = quill.getText().trim();
                console.log('Remark before submit:', remarkInput.value);
                const formData = new FormData(this);
                selectedFiles.forEach(file => {
                    formData.append('attachment[]', file);
                });
                for (let pair of formData.entries()) {
                    console.log(`${pair[0]}: ${pair[1]}`);
                }
                $.ajax({
                    url: this.action,
                    method: this.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message || 'Dispatch updated successfully!',
                        }).then(() => {
                            window.location.href = "{{ route('dispatch.index') }}";
                        });
                    },
                    error: function (xhr) {
                        const errors = xhr.responseJSON?.errors || {};
                        const errorMessage = Object.values(errors).flat().join('\n') || 'Failed to update dispatch.';
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
