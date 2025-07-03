@extends('backend.layout.auth')

@section('backend')
<div class="content-wrapper">
    <style>
        /* Capitalize first letter of table headers */
        .table thead th {
            text-transform: capitalize !important;
        }
    </style>
    <section class="section ms-4 me-4">
        <div class="content">
            <!-- /Page Header -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table show-entire">
                        <div class="card-body">
                            <!-- Table Header -->
                            <div class="page-table-header mb-4">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="font-weight-bold">Dispatch Index</h3>
                                    </div>
                                    <div class="col-auto text-end">
                                        <a href="{{ route('dispatch.create') }}" class="btn btn-primary btn-sm me-3">Create</a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover custom-table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">S#</th>
                                            <th>Title</th>
                                            <th>Folders</th>
                                            <th>Flags</th>
                                            <th>Office</th>
                                            <th>Date</th>
                                            <th>Send To</th>
                                            <th>Description</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($models as $model)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $model->title ?? 'NA' }}</td>
                                                <td>{{ $model->folder->title ?? 'NA' }}</td>
                                                <td>{{ $model->flag->title ?? 'NA' }}</td>
                                                <td>{{ $model->office->title ?? 'NA' }}</td>
                                                <td>{{ $model->date ?? 'NA' }}</td>
                                                <td>{{ $model->send_to ?? 'NA' }}</td>
                                                <td>{{ strip_tags($model->description) ?? 'N/A' }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-3">

                                                        <a href="{{ route('dispatch.edit', $model->id) }}" title="Edit">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </a>
                                                        <a href="{{ route('dispatch.delete', $model->id) }}" title="Delete" style="color: #dc3545;">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                            <!-- 👇 Show Details Button (DispatchDetails) -->
                                                        <a href="{{ route('dispatch.show', $model->id) }}" title="Show Details">
                                                            <i class="bi bi-eye"></i>
{{--                                                        </a>  <a href="{{ route('assigned.index', $model->id) }}" title="Show Details">--}}
{{--                                                          <i class="bi bi-list-ul"></i>--}}
{{--                                                         </a>--}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="13" class="text-center"><strong>No records found...</strong></td>
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
