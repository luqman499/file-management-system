@extends('backend.layout.auth')
@section('backend')
    <div class="content-wrapper">
        <section class="section ms-4 me-4">
            <div class="col-lg-12 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <!-- Back Button -->
                        <div class="d-flex justify-content-end mb-2">
                            <a href="{{ route('user.index') }}" class="btn btn-outline-primary btn-sm rounded-pill shadow-sm">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                        </div>

                        <!-- Heading -->
                        <h4 class="mb-4">View User</h4>

                        <div class="row g-3">

                            <!-- Name -->
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $model->name }}" disabled>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $model->email }}" disabled>
                            </div>

                            <!-- Password -->
                          <div class="col-md-6">
                              <label class="form-label">Password</label>
                              <input type="text" class="form-control form-control-sm" value="********" disabled>
                          </div>


                            <!-- CNIC -->
                            <div class="col-md-6">
                                <label class="form-label">CNIC</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $model->cnic }}" disabled>
                            </div>

                            <!-- Contact -->
                            <div class="col-md-6">
                                <label class="form-label">Contact</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $model->contact }}" disabled>
                            </div>

                            <!-- Office -->
                            <div class="col-md-6">
                                <label class="form-label">Office</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $model->office->title ?? 'N/A' }}" disabled>
                            </div>

                            <!-- Department -->
                            <div class="col-md-6">
                                <label class="form-label">Department</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $model->department->title ?? 'N/A' }}" disabled>
                            </div>

                            <!-- Image -->
                            <div class="col-md-6">
                                <label class="form-label">Image</label><br>
                                @if($model->image)
                                    <img src="{{ asset($model->image) }}" alt="User Image" class="img-thumbnail rounded" style="max-width: 120px;">
                                @else
                                    <p class="form-control form-control-sm text-muted" disabled>No Image</p>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
