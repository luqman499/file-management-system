@extends('backend.layout.auth')
@section('backend')
    <div class="content-wrapper">
        <section class="section ms-4">
            <div class="col-lg-8"> <!-- Centered Card -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <!-- Back Button -->
                        <div class="d-flex justify-content-end mb-2">
                            <a href="{{ route('office.index') }}"
                               class="btn btn-outline-primary btn-sm rounded-pill shadow-sm"
                               style="transition: all 0.3s ease;">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                        </div>

                        <!-- Form -->
                        {!! html()->form('PUT', route('office.update',$model->id))->attribute('enctype', 'multipart/form-data')->open() !!}
                        <div class="row g-3">
                            <!-- Form Heading -->
                            <div class="col-12">
                                <h4 class="mb-3">Edit Office</h4>
                            </div>

                            <!-- Title Input -->
                            <div class="col-md-6">
                                <div class="input-block local-forms">
                                    {!! html()->label('Title')->class('form-label') !!}
                                    {!! html()->text('title')->id('title')->class('form-control form-control-sm')->placeholder('Enter Title')->value($model->title) !!}
                                    @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Address Input -->
                            <div class="col-md-6">
                                <div class="input-block local-forms">
                                    {!! html()->label('Address')->class('form-label') !!}
                                    {!! html()->text('address')->id('address')->class('form-control form-control-sm')->placeholder('Enter Address')->value($model->address) !!}
                                    @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Contact -->
                            <div class="col-md-6">
                                <div class="input-block local-forms">
                                    {!! html()->label('Contact')->class('form-label') !!}
                                    {!! html()->number('contact')->id('contact')->class('form-control form-control-sm')->placeholder('Enter Contact')->value($model->contact) !!}
                                    @error('contact')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 text-end mt-3">
                                {!! html()->submit('Update')->class('btn btn-primary btn-sm rounded-pill')->style('padding: 6px 20px; font-size: 14px;') !!}
                            </div>
                        </div>
                        {!! html()->form()->close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
