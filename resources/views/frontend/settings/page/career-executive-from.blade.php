@extends('layouts.frontend')
@section('content-frontend')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <style>
        .card {
            padding: 30px 40px;
            margin-top: 10px;
            margin-bottom: 30px;
            border: none !important;
            box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.2)
        }

        .blue-text {
            color: #00BCD4
        }

        .form-control-label {
            margin-bottom: 0
        }

        .form-group input {
            height: 40px !important;
            font-size: 14px !important;
        }

        .form-control {
            border-radius: 0px !important;
        }

        input:focus,
        textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: 1px solid #00BCD4;
            outline-width: 0;
            font-weight: 400
        }

        .form-control-label {
            text-align: left;
            font-size: 16px;
            margin-left: -15px;
        }

        .chek-form {
            text-align: left;
            font-size: 16px;
        }

        .append-coloum .form-group {
            padding: 0;
        }

        button.submit, button[type='submit'] {
            padding: 5px 15px !important;
        }
    </style>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Page
                    <span></span> Career
                    <span></span> Executive Apply From
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-10 col-lg-10 col-md-10 col-12 text-center">
                        <div class="card">
                            <h4 class="text-center">Executive Apply From</h4>
                            <p class="blue-text">You have to fill the all blank field with valid information.</p>
                            <form class="form-card" method="post" action="{{ route('career.store')}}"enctype="multipart/form-data" id="form-data">
                                @csrf
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Name(Bangla)<span class="text-danger"> *</span>
                                        <input class="form-control" id="name_bangla" type="text" name="name_bangla" placeholder="Enter your name bangla" value="{{ old('name_bangla') }}" required>
                                        @error('name_bangla')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Name(English)<span class="text-danger"> *</span>
                                        <input class="form-control" id="name_english" type="text" name="name_english" placeholder="Enter your name english" value="{{ old('name_english') }}" required>
                                        @error('name_english')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Father/Husband Name<span class="text-danger"> *</span>
                                        <input class="form-control" id="father_name" type="text" name="father_name" placeholder="Enter your father/husband name" value="{{ old('father_name') }}" required>
                                        @error('father_name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Mother Name<span class="text-danger"> *</span>
                                        <input class="form-control" id="mother_name" type="text" name="mother_name" placeholder="Enter your mother name" value="{{ old('mother_name') }}" required>
                                        @error('mother_name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Education<span class="text-danger"> *</span>
                                        <input class="form-control" id="education" type="text" name="education" placeholder="Enter educational information" value="{{ old('education') }}" required>
                                        @error('education')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Date of birth<span class="text-danger"> *</span>
                                        <input class="form-control" id="dob" type="date" name="dob" value="{{ old('dob') }}" required>
                                        @error('dob')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Phone<span class="text-danger"> *</span>
                                        <input class="form-control" id="phone" type="text" name="phone" placeholder="Enter phone number" value="{{ old('phone') }}" required>
                                        @error('phone')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Email<span class="text-danger"> *</span>
                                        <input class="form-control" id="email" type="email" name="email" placeholder="Enter email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">National ID No<span class="text-danger"> *</span>
                                        <input class="form-control" id="national_id" type="text" name="national_id" placeholder="Enter National ID No" value="{{ old('national_id') }}" required>
                                        @error('national_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Religious<span class="text-danger"> *</span>
                                        <input class="form-control" id="religious" type="text" name="religious" placeholder="Enter your religious" value="{{ old('religious') }}" required>
                                        @error('religious')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Blood Group<span class="text-danger"> *</span></label>
                                        <select class="form-control" id="blood_g" name="blood_g" required>
                                            <option value="">Select your Blood Group</option>
                                            <option value="A+" {{ old('blood_g') == 'A+' ? 'selected' : '' }}>A+</option>
                                            <option value="A-" {{ old('blood_g') == 'A-' ? 'selected' : '' }}>A-</option>
                                            <option value="B+" {{ old('blood_g') == 'B+' ? 'selected' : '' }}>B+</option>
                                            <option value="B-" {{ old('blood_g') == 'B-' ? 'selected' : '' }}>B-</option>
                                            <option value="AB+" {{ old('blood_g') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                            <option value="AB-" {{ old('blood_g') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                            <option value="O+" {{ old('blood_g') == 'O+' ? 'selected' : '' }}>O+</option>
                                            <option value="O-" {{ old('blood_g') == 'O-' ? 'selected' : '' }}>O-</option>
                                        </select>
                                        @error('blood_g')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>


                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Ocupation<span class="text-danger"> *</span>
                                        <input class="form-control" id="ocupation" type="text" name="ocupation" placeholder="Enter your Ocupation" value="{{ old('ocupation') }}" required>
                                        @error('ocupation')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Designation<span class="text-danger"> *</span>
                                        <input class="form-control" id="designation" type="text" name="designation" placeholder="Enter your Designation" value="{{ old('designation') }}" required>
                                        @error('designation')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Professional address<span class="text-danger"> *</span>
                                        <input class="form-control" id="professional_add" type="text" name="professional_add" placeholder="Enter your professional address" value="{{ old('professional_add') }}" required>
                                        @error('professional_add')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Present Address<span class="text-danger"> *</span>
                                        <input class="form-control" id="present_add" type="text" name="present_add" placeholder="Enter your Present address" value="{{ old('present_add') }}" required>
                                        @error('present_add')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Permanent address<span class="text-danger"> *</span>
                                        <input class="form-control" id="permanent_add" type="text" name="permanent_add" placeholder="Enter your permanent address" value="{{ old('permanent_add') }}" required>
                                        @error('permanent_add')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <img id="showImage" class="rounded avatar-lg" src="{{ (!empty($editData->profile_image))? url('upload/admin_images/'.$editData->profile_image):url('upload/no_image.jpg') }}" alt="Card image cap" width="100px" height="80px;">
                                        <label class="form-control-label px-3">Image<span class="text-danger"> *</span>
                                        <input name="image" class="form-control" type="file" id="image">
                                        @error('image')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12" style="padding: 9px 40px !important;">
                                        <button type="submit" class="btn btn-primary btn-block" style="float: right; border-radius: 0px;">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('footer-script')
@endpush
