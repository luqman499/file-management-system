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
                                            <span>{{ $dispatch->submitted_by ?? 'N/A' }}</span>
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
                                <h6 class="fw-semibold text-dark mb-3 border-bottom pb-2">Paras/Remarks/Description</h6>
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
                                @forelse ($dispatch->dispatchDocuments as $attachment)
                                    <div class="attachment-item d-flex align-items-center p-3 bg-light rounded-2 mb-3 border transition-all">
                                        @if(in_array(strtolower(pathinfo($attachment->file, PATHINFO_EXTENSION)), ['png', 'jpg', 'jpeg']))
                                            <img src="{{ asset('storage/' . $attachment->file) }}" alt="{{ $attachment->title ?? 'Attachment' }}" class="me-3 rounded" style="max-width: 80px; height: auto;">
                                        @else
                                            <i class="bi bi-file-earmark-text fs-4 me-3 text-primary"></i>
                                        @endif
                                        <div class="flex-grow-1">
                                            <span class="fw-medium text-dark">{{ $attachment->title ?? 'Untitled Document' }}</span>
                                            <small class="d-block text-muted">{{ strtoupper(pathinfo($attachment->file, PATHINFO_EXTENSION)) }} • {{ $attachment->file_size ?? 'Unknown' }} KB</small>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ asset('storage/' . $attachment->file) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye me-1"></i>Preview
                                            </a>
                                            <a href="{{ asset('storage/' . $attachment->file) }}" download class="btn btn-outline-success btn-sm">
                                                <i class="bi bi-download me-1"></i>Download
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted">No attachments available.</p>
                                @endforelse
                            </div>

                            <!-- Dispatch Details Documents -->
                            <div class="mb-5">
                                <h6 class="fw-semibold text-dark mb-3 border-bottom pb-2">Dispatch Details Documents</h6>
                                @if($dispatch->dispatchDetails && $dispatch->dispatchDetails->flatMap->documents->count())
                                    <div class="table-responsive rounded-2 border">
                                        <table class="table table-hover mb-0">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th scope="col" class="fw-semibold text-muted">S#</th>
                                                    <th scope="col" class="fw-semibold text-muted">Title</th>
                                                    <th scope="col" class="fw-semibold text-muted">File</th>
                                                    <th scope="col" class="fw-semibold text-muted">Associated User</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($dispatch->dispatchDetails as $detail)
                                                    @forelse($detail->documents as $document)
                                                        <tr class="transition-all">
                                                            <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                                            <td>{{ $document->title ?? 'N/A' }}</td>
                                                            <td>
                                                                <div class="d-flex gap-2">
                                                                    <a href="{{ asset('storage/' . $document->file) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                                        <i class="bi bi-eye me-1"></i>Preview
                                                                    </a>
                                                                    <a href="{{ asset('storage/' . $document->file) }}" download class="btn btn-outline-success btn-sm">
                                                                        <i class="bi bi-download me-1"></i>Download
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            <td>{{ optional($detail->user)->name ?? 'N/A' }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-muted">No documents for this detail.</td>
                                                        </tr>
                                                    @endforelse
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">No dispatch details documents available.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
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
        .detail-item {
            transition: background-color 0.2s ease;
            padding: 0.5rem 0;
        }
        .detail-item:hover {
            background-color: #f1f3f5;
            border-radius: 0.25rem;
        }
        .attachment-item {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .attachment-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15rd);
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
        @media (max-width: 767px) {
            .content-wrapper {
                padding: 1rem;
            }
            .card-body {
                padding: 1rem;
            }
            .detail-item {
                flex-direction: column;
                align-items: start;
            }
            .detail-item span:first-child {
                margin-bottom: 0.25rem;
            }
            .table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            .table th, .table td {
                min-width: 120px;
            }
        }
    </style>
@endsection