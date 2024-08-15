@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Edit Career</h2>
        <div class="">
            <a href="{{ route('career.index') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>Back To List</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form method="post" action="{{ route('career.update', $career->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-6 form-group mb-4">
                                        <label class="col-form-label" for="name_bangla">Name(Bangla)</label>
                                        <input type="text" placeholder="Enter your name bangla" id="name_bangla" name="name_bangla" value="{{$career->name_bangla}}" class="form-control" >
                                        @error('name_bangla')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>

                                    <div class="col-6 form-group mb-4">
                                        <label class="col-form-label" for="name_english">Name(English)</label>
                                        <input type="text" placeholder="Enter your name english" id="name_english" name="name_english" value="{{$career->name_english}}" class="form-control" >
                                        @error('name_english')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 form-group mb-4">
                                        <label class="col-form-label" for="father_name">Father/Husband Name</label>
                                        <input type="text" placeholder="Enter your father/husband name" id="father_name" name="father_name" value="{{$career->father_name}}" class="form-control" >
                                        @error('father_name')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>

                                    <div class="col-6 form-group mb-4">
                                        <label class="col-form-label" for="mother_name">Mother Name</label>
                                        <input type="text" placeholder="Enter your mother name" id="mother_name" name="mother_name" value="{{$career->mother_name}}" class="form-control" >
                                        @error('mother_name')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 form-group mb-4">
                                        <label class="col-form-label" for="education">Education</label>
                                        <input type="text" placeholder="Enter educational information" id="education" name="education" value="{{$career->education}}" class="form-control" >
                                        @error('education')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>

                                    <div class="col-6 form-group mb-4">
                                        <label class="col-form-label" for="dob">Date of birth</label>
                                        <input type="date" placeholder="Enter your date of birth" id="dob" name="dob" value="{{$career->dob}}" class="form-control" >
                                        @error('dob')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 form-group mb-4">
                                        <label class="col-form-label" for="phone">Phone</label>
                                        <input type="text" placeholder="Enter your phone" id="phone" name="phone" value="{{$career->phone}}" class="form-control" >
                                        @error('phone')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="col-6 form-group mb-4">
                                        <label class="col-form-label" for="email">Email</label>
                                        <input type="email" placeholder="Enter your email" id="email" name="email" value="{{$career->email}}" class="form-control" >
                                        @error('email')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 form-group mb-4">
                                        <label class="col-form-label" for="national_id">National ID No</label>
                                        <input type="text" placeholder="Enter National ID No" id="national_id" name="national_id" value="{{$career->national_id}}" class="form-control" >
                                        @error('national_id')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>


                                    <div class="col-6 form-group mb-4">
                                        <label class="col-form-label" for="religious">Religious</label>
                                        <input type="text" placeholder="Enter your religious" id="religious" name="religious" value="{{$career->religious}}" class="form-control" >
                                        @error('religious')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 form-group mb-4">
                                        <label class="col-form-label" for="blood_g">Blood Group</label>
                                        <select class="form-control" id="blood_g" name="blood_g" required>
                                            <option value="">Select your Blood Group</option>
                                            <option value="A+" {{ old('blood_g', $career->blood_g) == 'A+' ? 'selected' : '' }}>A+</option>
                                            <option value="A-" {{ old('blood_g', $career->blood_g) == 'A-' ? 'selected' : '' }}>A-</option>
                                            <option value="B+" {{ old('blood_g', $career->blood_g) == 'B+' ? 'selected' : '' }}>B+</option>
                                            <option value="B-" {{ old('blood_g', $career->blood_g) == 'B-' ? 'selected' : '' }}>B-</option>
                                            <option value="AB+" {{ old('blood_g', $career->blood_g) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                            <option value="AB-" {{ old('blood_g', $career->blood_g) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                            <option value="O+" {{ old('blood_g', $career->blood_g) == 'O+' ? 'selected' : '' }}>O+</option>
                                            <option value="O-" {{ old('blood_g', $career->blood_g) == 'O-' ? 'selected' : '' }}>O-</option>
                                        </select>
                                        @error('blood_g')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-6 form-group mb-4">
                                        <label class="col-form-label" for="ocupation">Ocupation</label>
                                        <input type="text" placeholder="Enter your ocupation" id="ocupation" name="ocupation" value="{{$career->ocupation}}" class="form-control" >
                                        @error('ocupation')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 form-group mb-4">
                                        <label class="col-form-label" for="designation">Designation</label>
                                        <input type="text" placeholder="Enter your designation" id="designation" name="designation" value="{{$career->designation}}" class="form-control" >
                                        @error('designation')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>


                                    <div class="col-6 form-group mb-4">
                                        <label class="col-form-label" for="professional_add">Professional address</label>
                                        <input type="text" placeholder="Enter your professional address" id="professional_add" name="professional_add" value="{{$career->professional_add}}" class="form-control" >
                                        @error('professional_add')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 form-group mb-4">
                                        <label class="col-form-label" for="present_add">Present Address</label>
                                        <input type="text" placeholder="Enter your Present address" id="present_add" name="present_add" value="{{$career->present_add}}" class="form-control" >
                                        @error('present_add')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>

                                    <div class="col-6 form-group mb-4">
                                        <label class="col-form-label" for="permanent_add">Permanent address</label>
                                        <input type="text" placeholder="Enter your permanent address" id="permanent_add" name="permanent_add" value="{{$career->permanent_add}}" class="form-control" >
                                        @error('permanent_add')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6 row">
                                    <div class="mb-4">
                                        <label for="image" class="col-form-label" style="font-weight: bold;">Photo:</label>
                                        <input name="image" class="form-control" type="file" id="image">
                                    </div>
                                    <div class="mb-4">
                                        <img id="showImage" class="rounded avatar-lg" src="{{ asset($career->image) }}" alt="Card image cap" width="100px" height="80px;">
                                    </div>
                                </div>

                                <div class="row mb-4" style="float:right;">
                                    <div class="col-lg-3 col-md-4 col-sm-5 col-6">
                                        <input type="submit" class="btn btn-primary" value="Update">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
