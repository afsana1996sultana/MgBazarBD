<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="{{ asset(get_setting('business_name')->value) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="{{ (get_setting('site_name')->value) }}">
    <meta property="og:type" content="{{ asset(get_setting('site_name')->value) }}">
    <meta property="og:url" content="{{ asset(get_setting('developer_link')->value) }}">
    <meta property="og:image" content="{{ asset(get_setting('site_logo')->value) }}">
    <title>{{ (get_setting('site_name')->value) }}</title>
    <!-- Favicon -->
    @php
        $logo = get_setting('site_favicon');
    @endphp
    @if($logo != null)
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset(get_setting('site_favicon')->value) }}">
    @else
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('upload/no_image.jpg') }}" alt="{{ env('APP_NAME') }}">
    @endif

    <title>{{ config('app.name', 'Laravel') }}</title>
  
    <!-- fontawsome -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/all.min.css') }}">

    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}">

    <!-- toastr css--> 
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/toastr.css') }}" >

    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/vendors_css.css ' )}}">
      
    <!-- Style-->  
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css ')}}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/skin_color.css ')}}">   
</head>

<body class="hold-transition theme-primary bg-img">
    
    <div class="container h-p100">
        <div class="row align-items-center justify-content-md-center h-p100">
            
            <div class="col-12">
                <div class="row justify-content-center g-0">
                    <div class="col-lg-5 col-md-5 col-12">                      
                        <div class="bg-white rounded10 shadow-lg">
                            <div class="content-top-agile p-20 pb-0">
                                <h3 class="mb-0 text-primary">Recover Password</h3>                             
                            </div>
                            <div class="p-40">
                                <form action="{{ route('password.email') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-transparent"><i class="ti-email"></i></span>
                                            <input type="email" class="form-control ps-15 bg-transparent" placeholder="Your Email" name="email" required>
                                        </div>
                                    </div>
                                      <div class="row">
                                        <div class="col-12 text-center">
                                          <button type="submit" class="btn  btn-info btn-block margin-top-10">Reset</button>
                                        </div>
                                        <!-- /.col -->
                                      </div>
                                </form> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  

    <!-- Vendor JS -->
    <script src="{{ asset('backend/assets/js/vendors.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/chat-popup.js') }}"></script>
    <script src="{{ asset('backend/assets/icons/feather-icons/feather.min.js' ) }}"></script>

    <!-- bootstrap js -->
    <script src="{{ asset('backend/assets/js/jquery-3.2.1.slim.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/bootstrap.min.js') }}"></script> 

</body>

</html>