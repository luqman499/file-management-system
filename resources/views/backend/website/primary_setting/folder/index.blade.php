@extends('backend.layout.auth')

@section('backend')
    <div class="content-wrapper">
        <section class="section ms-4">
            <div class="content">
                <div class="row justify-content-left">
                    <div class="col-lg-10">

                        <!-- Card Container -->
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">

                                <!-- Page Header -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h3 class="mb-0">Folder Index</h3>
                                    <a href="{{ route('folder.create') }}"
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
                                            <th style="width: 25%; text-align: left;">Code</th>
                                            <th style="width: 20%;">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($models as $model)
                                            <tr>
                                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                                <td class="align-middle" style="text-align: left;">{{ $model->title ?? 'NA' }}</td>
                                                <td class="align-middle" style="text-align: left;">{{ $model->code ?? 'NA' }}</td>
                                                <td class="text-center align-middle">
                                                    <div class="d-flex justify-content-center gap-3">
                                                        <a href="{{ route('folder.edit', $model->id) }}" title="Edit">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </a>
                                                        <a href="{{ route('folder.delete', $model->id) }}" title="Delete" style="color: #dc3545;">
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
