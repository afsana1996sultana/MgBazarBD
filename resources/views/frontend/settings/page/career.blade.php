@extends('layouts.frontend')
@section('title')
    Career
@endsection
@push('css')
    <style>
        .breadcrumb-wrap {
            background-color: #f8f9fa;
            padding: 20px 0;
        }

        .breadcrumb a {
            color: #007bff;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .card-deck {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card-deck .card {
            margin: 10px;
            flex: 1;
        }

        .card-img-top {
            height: 350px;
            object-fit: cover;
        }

        .card-title {
            color: #333;
        }

        .card-text {
            color: #666;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
@endpush
@section('content-frontend')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home')}}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Page
                    <span></span> Career
                </div>
            </div>
        </div>
        <div class="container mt-20">
            <div class="row justify-content-center">
                <div class="col-lg-10 mb-40">
                    <div class="card-deck d-flex">
                        <div class="card mb-4 shadow-sm">
                            <a href="{{ route('career-executive-apply-from') }}"><img class="card-img-top" src="{{asset('frontend/assets/imgs/page/career/career-1.webp')}}" alt="Card image cap"></a>
                            <div class="card-body">
                                <a href="{{ route('career-executive-apply-from') }}"><h5 class="card-title">Executive(Sales & Marketing)</h5></a>
                              <p class="card-text">If you want to apply for Executive(Sales & Marketing) position then you have to fill the application form.</p>
                              <a href="{{ route('career-executive-apply-from') }}" class="btn btn-primary">Apply Now</a>
                            </div>
                        </div>

                        <div class="card mb-4 shadow-sm">
                            <a href=" "><img class="card-img-top" src="{{asset('frontend/assets/imgs/page/career/career-1.webp')}}" alt="Card image cap"></a>
                            <div class="card-body">
                              <a href=""><h5 class="card-title">Dealler(For Business)</h5></a>
                              <p class="card-text">If you want to become a Dealler(For Business) then you have to fill the application form.</p>
                              <a href="#" class="btn btn-primary">Apply Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
