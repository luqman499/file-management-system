@extends('backend.layout.auth')

@section('backend')
    <div class="content-wrapper">
        <style>
            /* Capitalize first letter of table headers */
            .table thead th {
                text-transform: capitalize !important;
            }
            /* Ensure modal z-index is above sidebar */
            .modal {
                z-index: 1055;
            }
        </style>
        <section class="section me-4">
            <div class="content">
                <!-- Page Header -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-table show-entire">
                            <div class="card-body">
                                <!-- Table Header -->
                                <div class="page-table-header mb-4">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="font-weight-bold">  Approved Tasks ( {{ $models->count() }} )</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover custom-table">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">S#</th>
                                            <th>Title</th>
                                            <th>Office</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Dispatch Number</th>
                                            <th>Folders</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($models as $model)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $model->dispatch->title ?? 'N/A' }}</td>
                                                <td>{{ $model->dispatch->office->title ?? 'N/A' }}</td>
                                                <td>{{ $model->dispatch->data ?? 'N/A' }}</td>
                                                <td>{{ $model->dispatch->time ?? 'N/A' }}</td>
                                                <td>{{ $model->dispatch->dispatch_number ?? 'N/A' }}</td>
                                                <td>{{ $model->dispatch->folder->title ?? 'N/A' }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-3">
                                                        <a href="{{ route('dispatch.show', $model->id) }}">View</a>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center"><strong>No records found...</strong></td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection

