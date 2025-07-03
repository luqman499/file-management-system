
@extends('backend.layout.auth')

@section('backend')
    <div class="content-wrapper">
        <section class="section ms-4 me-4">
            <div class="content">
                <div class="row justify-content-center">
                    <div class="col-lg-12">

                        <!-- Card Container -->
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">

                                <!-- Page Header -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h3 class="mb-0">Users Index</h3>
                                    <a href="{{ route('user.create') }}"
                                       class="btn btn-outline-primary btn-sm rounded-pill shadow-sm">
                                        <i class="bi bi-plus-circle me-1"></i> Create
                                    </a>
                                </div>

                                <!-- Table -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover custom-table">
                                        <thead class="custom-table-header text-center">
                                        <tr>
                                            <th style="width: 5%;">S#</th>
                                            <th style="width: 40%; text-align: left;">Name</th>
                                            <th style="width: 25%; text-align: left;">Email</th>
{{--                                            <th style="width: 25%; text-align: left;">Cnic</th>--}}
{{--                                            <th style="width: 25%; text-align: left;">Contact</th>--}}
                                            <th style="width: 25%; text-align: left;">Offices</th>
                                            <th style="width: 25%; text-align: left;">Department</th>
                                            <th style="width: 25%; text-align: left;">Image</th>
                                            <th style="width: 20%;">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($models as $model)
                                            <tr>
                                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                                <td class="align-middle" style="text-align: left;">{{ $model->name ?? 'NA' }}</td>
                                                <td class="align-middle" style="text-align: left;">{{ $model->email ?? 'NA' }}</td>
{{--                                                <td class="align-middle" style="text-align: left;">{{ $model->cnic ?? 'NA' }}</td>--}}
{{--                                                <td class="align-middle" style="text-align: left;">{{ $model->contact ?? 'NA' }}</td>--}}
                                                <td class="align-middle" style="text-align: left;">{{ $model->office->title ?? 'NA' }}</td>
                                                <td class="align-middle" style="text-align: left;">{{ $model->department->name ?? 'NA' }}</td>
{{--                                                <td class="align-middle" style="text-align: left;"><img src="{{ asset($model->image) }}"  style="width:40px; height: 40px;">?? 'N/A'</td>--}}
                                                <td class="align-middle" style="text-align: left;">
                                                    {!! $model->image ? '<img src="' . asset($model->image) . '" style="width:40px; height: 40px;" alt="Image">' : 'N/A' !!}
                                                </td>

                                                <td class="text-center align-middle">
                                                    <div class="d-flex justify-content-center gap-3">
                                                        <a href="{{ route('user.show', $model->id) }}" title="View" style="color: #0d6efd;">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </a>
                                                        <a href="{{ route('user.edit', $model->id) }}" title="Edit">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </a>
                                                        <a href="{{ route('user.delete', $model->id) }}" title="Delete" style="color: #dc3545;">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center"><strong>No records found...</strong></td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>

                                </div> <!-- End table-responsive -->

                            </div> <!-- End card-body -->
                        </div> <!-- End card -->

                    </div> <!-- End col -->
                </div> <!-- End row -->
            </div> <!-- End content -->
        </section>
    </div>
@endsection
