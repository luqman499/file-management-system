@extends('backend.layout.auth')
@section('backend')
    <div class="content-wrapper">
        <section class="section ms-4 me-4">
            <div class="col-lg-12 mx-auto"> <!-- Centered Card -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <!-- Back Button -->
                        <div class="d-flex justify-content-end mb-2">
                            <a href="{{ route('user.index') }}"
                               class="btn btn-outline-primary btn-sm rounded-pill shadow-sm"
                               style="transition: all 0.3s ease;">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                        </div>

                        <!-- Form -->
                        {!! html()->form('POST', route('user.store'))->attribute('enctype', 'multipart/form-data')->open() !!}
                        <div class="row g-3">
                            <!-- Form Heading -->
                            <div class="col-12">
                                <h4 class="mb-3">Create Users</h4>
                            </div>

                            <!-- Title Input -->
                            <div class="col-md-6">
                                <div class="input-block local-forms">
                                    {!! html()->label('name')->class('form-label') !!}
                                    {!! html()->text('name')->id('name')->class('form-control form-control-sm')->placeholder('Enter Name') !!}
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email Input -->
                            <div class="col-md-6">
                                <div class="input-block local-forms">
                                    {!! html()->label('Email')->class('form-label') !!}
                                    {!! html()->text('email')->id('email')->class('form-control form-control-sm')->placeholder('Enter Email') !!}
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                         <!-- Password Input -->
                            <div class="col-md-6">
                                <div class="input-block local-forms">
                                    {!! html()->label('Password')->class('form-label') !!}
                                     {!! html()->password('password')->id('password')->class('form-control form-control-sm')->placeholder('Enter Password') !!}
                                  @error('password')
                                  <span class="text-danger">{{ $message }}</span>
                                   @enderror
                                 </div>
                            </div>
                            <!-- Cnic Input -->
                            <div class="col-md-6">
                                <div class="input-block local-forms">
                                    {!! html()->label('Cnic')->class('form-label') !!}
                                    {!! html()->text('cnic')->id('cnic')->class('form-control form-control-sm')->placeholder('Enter Cnic') !!}
                                    @error('cnic')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Number Input -->
                            <div class="col-md-6">
                                <div class="input-block local-forms">
                                    {!! html()->label('Contact')->class('form-label') !!}
                                    {!! html()->number('contact')->id('contact')->class('form-control form-control-sm')->placeholder('Enter Number') !!}
                                    @error('contact')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Office Input -->
                            <div class="col-md-6">
                                <div class="input-block local-forms">
                                    {!! html()->label('Offices')->class('form-label') !!}
                                    {!! html()->select('office_id', $offices)->id('office_id')->class('form-select')->placeholder('Select Office') !!}
                                    @error('office_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Department Input -->
                            <div class="col-md-6">
                                <div class="input-block local-forms">
                                    {!! html()->label('Department')->class('form-label') !!}
                                    {!! html()->select('department_id', $departments)->id('department_id')->class('form-select')->placeholder('Select Department') !!}
                                    @error('department_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-block local-forms">
                                    {{-- Label --}}
                                    {!! html()->label('Image')->class('form-label') !!}

                                    {{-- Image Preview (Initially hidden) --}}
                                    <div id="imagePreviewWrapper" class="mb-2" style="display: none;">
                                        <img id="imagePreview"
                                             class="img-thumbnail rounded shadow-sm"
                                             style="max-width: 80px; height: 80px; object-fit: cover;"
                                             alt="Image Preview">
                                    </div>

                                    {{-- File Input --}}
                                    {!! html()->file('image')
                                        ->id('image')
                                        ->class('form-control form-control-sm')
//                                        ->accept('image/*')
                                    !!}

                                    {{-- Error --}}
                                    @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <!-- Submit Button -->
                            <div class="col-12 text-start mt-3">
                                {!! html()->submit('Submit')->class('btn btn-primary btn-sm rounded-pill')->style('padding: 6px 20px; font-size: 14px;') !!}
                            </div>
                        </div>
                        {!! html()->form()->close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        document.getElementById('image').addEventListener('change', function (event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');
            const wrapper = document.getElementById('imagePreviewWrapper');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    wrapper.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                wrapper.style.display = 'none';
                preview.src = '';
            }
        });
    </script>


@endsection



