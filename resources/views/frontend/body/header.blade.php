<header class="header-area header-style-1 header-height-2">
    <div class="header-top header-top-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <div class="header-info">
                        <ul>
                            <li class="contact_header"><strong><a href="tel:{{ get_setting('phone')->value ?? '' }}">Need help? Call Us: <i class="fa fa-phone ms-1"></i> {{ get_setting('phone')->value ?? ''}}</a></strong></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="text-center">
                        <div id="news-flash" class="d-inline-block">
                            <ul>
                                <li><span style="color: green; ">“ এমজি &nbsp; বাজার &nbsp; আছে ,&nbsp;</span> <span style="color: red;"> আপনার &nbsp; পাশে ”</span></li>
                                <li><span style="color: green; ">“ এমজি &nbsp; বাজার &nbsp; আছে ,&nbsp;</span> <span style="color: black;"> আপনার &nbsp; পাশে ”</span></li>
                                <li><span style="color: green; ">“ এমজি &nbsp; বাজার &nbsp; আছে ,&nbsp;</span> <span style="color: blue;"> আপনার &nbsp; পাশে ”</span></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="header-info header-info-right">
                        <ul>
                           <li><a href="#" class="btn btn-xs" data-bs-toggle="modal" data-bs-target="#vendor_service" style="color: #fff;">Become a Vendor</a></li>
                           <li><a href="{{ route('order.tracking') }}">Order Tracking</a></li>
                            <li>
                                @if(session()->get('language') == 'bangla')
                                    <a class="language-dropdown-active" href="{{ route('english.language') }}">English</a>
                                @else
                                    <a class="language-dropdown-active" href="{{ route('bangla.language') }}">বাংলা</a>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-lg-block sticky-bar">
        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="header-wrap">
                    <div class="logo logo-width-1">
                        <a href="{{route('home')}}">
                            @php
                                $logo = get_setting('site_logo');
                            @endphp
                            @if($logo != null)
                                <img src="{{ asset(get_setting('site_logo')->value ?? 'null') }}" alt="{{ env('APP_NAME') }}">
                            @else
                                <img src="{{ asset('upload/no_image.jpg') }}" alt="{{ env('APP_NAME') }}" style="height: 60px !important; width: 80px !important; min-width: 80px !important;">
                            @endif
                        </a>
                    </div>
                    <div class="header-right">
                        <div class="search-style-2">
                            <div class="search-area">
                                <form action="{{ route('product.search') }}" method="post" class="mx-auto">
                                    @csrf
                                    <select class="select-active" name="searchCategory" id="searchCategory">
                                        <option value="0">All Categories</option>
                                        @foreach (get_all_categories() as $cat)
                                            <option value="{{ $cat->id }}">
                                                @if (session()->get('language') == 'bangla')
                                                {{ $cat->name_bn }}
                                                @else
                                                {{ $cat->name_en }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <input class="search-field search" onfocus="search_result_show()" onblur="search_result_hide()" name="search" placeholder="Search here..." />
                                    <div>
                                        <button type="submit" class="text-white bg-brand btn btn-primary btn-sm rounded-0"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </form>

                            </div>
                            <div class="shadow-lg searchProducts"></div>
                        </div>
                        <div class="header-action-right">
                            <div class="header-action-2">
                                <div class="header-action-2 cart_hidden_mobile me-2">
                                    @foreach(get_pages_both_footer() as $page)
                                        <a href="{{ route('page.about', $page->slug) }}" class="btn btn-xs">
                                            {{ $page->title }}
                                        </a>
                                    @endforeach
                                </div>

                                <div class="header-action-2 cart_hidden_mobile me-2">
                                    <div class="header-action-icon-2">
                                        <a class="mini-cart-icon" href="#">
                                            <img alt="Nest" src="{{asset('frontend/assets/imgs/theme/icons/icon-cart.svg')}}">
                                            <span class="pro-count blue cartQty"></span>
                                        </a>
                                        <a href="{{ route('cart.show') }}"><span class="lable">Cart</span></a>
                                        <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                            <div id="miniCart">

                                            </div>
                                            <div class="shopping-cart-footer" id="miniCart_btn">
                                                <div class="shopping-cart-total">
                                                    <h4>Total <span id="cartSubTotal"></span></h4>
                                                </div>
                                                <div class="shopping-cart-button">
                                                    <a href="{{ route('cart.show') }}" class="outline">View cart</a>
                                                    <a href="{{ route('checkout')}}">Checkout</a>
                                                </div>
                                            </div>
                                            <div class="shopping-cart-footer" id="miniCart_empty_btn">

                                                <div class="shopping-cart-button d-flex flex-row-reverse">
                                                    <a  href="{{ route('home')}}">Continue Shopping</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="header-action-icon-2">
                                    @auth
                                    <a href="#">
                                        <img class="svgInject" alt="Nest" src="{{asset('frontend/assets/imgs/theme/icons/icon-user.svg')}}">
                                    </a>
                                    <a href="{{route('dashboard')}}"><span class="lable ml-0">Account</span></a>
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                        <ul>
                                            <li>
                                                <a href="{{route('dashboard')}}"><i class="fi fi-rs-user mr-10"></i>My Account</a>
                                            </li>
                                            <li>
                                                <a class=" mr-10" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <i class="fi-rs-sign-out mr-10"></i>
                                                    {{ __('Logout') }}
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                    @endauth
                                    @guest
                                    <a href="{{ route('login') }}"><span class="lable ml-0"><i class="fa-solid fa-arrow-right-to-bracket mr-10"></i>Login</span></a>
                                    @endguest

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom header-bottom-bg-color">
            <div class="container">
                <div class="header-wrap header-space-between position-relative">
                    <div class="logo logo-width-1 d-block d-lg-none">
                        <a href="{{route('home')}}">
                            @php
                                $logo = get_setting('site_logo');
                            @endphp
                            @if($logo != null)
                                <img src="{{ asset(get_setting('site_logo')->value ?? 'null') }}" alt="{{ env('APP_NAME') }}">
                            @else
                                <img src="{{ asset('upload/no_image.jpg') }}" alt="{{ env('APP_NAME') }}" style="height: 60px !important; width: 80px !important; min-width: 80px !important;">
                            @endif
                        </a>
                    </div>
                    <div class="header-nav d-none d-lg-flex">
                        <div class="main-categori-wrap d-none d-lg-block">
                            <a class="categories-button-active" href="#">
                                <span class="fi-rs-apps"></span> <span class="et">Browse</span>
                                <span>Categories</span>
                                <i class="fi-rs-angle-down"></i>
                            </a>
                            <div class="categories-dropdown-wrap categories-dropdown-active-large font-heading">
                                <div class="d-flex categori-dropdown-inner">
                                    <ul style="width: 100%;">
                                        @foreach(get_categories()->take(8) as $cat)
                                        <li style="width: 45%; float: left;">
                                            <a href="{{ route('product.category', $cat->slug) }}">
                                                <img src="{{asset($cat->image )}}" alt="">
                                                @if(session()->get('language') == 'bangla')
                                                    {{ $cat->name_bn }}
                                                @else
                                                    {{ $cat->name_en }}
                                                @endif
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <a href="{{ route('category_list.index') }}" class="more_categories"><span class="heading-sm-1">View More Categories</span></a>
                            </div>
                        </div>
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                            <nav>
                                <ul>
                                    <li>
                                        <a href="{{ route('home') }}">
                                            @if(session()->get('language') == 'bangla')
                                                হোম
                                            @else
                                                Home
                                            @endif
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('product.show') }}">
                                            @if(session()->get('language') == 'bangla')
                                                দোকান
                                            @else
                                                Shop
                                            @endif
                                        </a>
                                    </li>
                                    <!-- Start Mega Menu -->
                                    @foreach(get_categories()->take(8) as $category)
                                        @if($category->has_sub_sub > 0)
                                            <li class="position-static">
                                                <a href="{{ route('product.category', $category->slug) }}">
                                                    @if(session()->get('language') == 'bangla')
                                                        {{ $category->name_bn }}
                                                    @else
                                                        {{ $category->name_en }}
                                                    @endif
                                                    @if($category->sub_categories && count($category->sub_categories) > 0)
                                                        <i class="fi-rs-angle-down"></i>
                                                    @endif
                                                </a>
                                                @if($category->sub_categories && count($category->sub_categories) > 0)
                                                    <ul class="mega-menu">
                                                        @foreach($category->sub_categories as $sub_category)
                                                            <li class="sub-mega-menu sub-mega-menu-width-22">
                                                                <a class="menu-title" href="{{ route('product.category', $sub_category->slug) }}">
                                                                    @if(session()->get('language') == 'bangla')
                                                                        {{ $sub_category->name_bn }}
                                                                    @else
                                                                        {{ $sub_category->name_en }}
                                                                    @endif
                                                                </a>
                                                                @if($sub_category->sub_sub_categories && count($sub_category->sub_sub_categories) > 0)
                                                                    <ul>
                                                                        @foreach($sub_category->sub_sub_categories as $sub_sub_category)
                                                                            <li><a href="{{ route('product.category', $sub_sub_category->slug) }}">
                                                                                @if(session()->get('language') == 'bangla')
                                                                                    {{ $sub_sub_category->name_bn }}
                                                                                @else
                                                                                    {{ $sub_sub_category->name_en }}
                                                                                @endif
                                                                            </a></li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @else
                                        <li>
                                            <a href="{{ route('product.category', $category->slug) }}">
                                            @if(session()->get('language') == 'bangla')
                                                {{ $category->name_bn }}
                                            @else
                                                {{ $category->name_en }}
                                            @endif
                                            @if($category->sub_categories && count($category->sub_categories) > 0)
                                            <i class="fi-rs-angle-down"></i>
                                            @endif
                                            </a>

                                            @if($category->sub_categories && count($category->sub_categories) > 0)
                                            <ul class="sub-menu">
                                                @foreach($category->sub_categories as $sub_category)
                                                <li><a href="{{ route('product.category', $sub_category->slug) }}">{{$sub_category->name_en}}</a></li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        @endif
                                    @endforeach
                                    @foreach(get_pages_nav()->take(1) as $page)
                                    <li>
                                        <a href="{{ route('page.about', $page->slug) }}">
                                            {{ $page->title }}
                                        </a>
                                    </li>
                                    @endforeach
                                    <li><a href="{{ route('career')}}">Career</a></li>
                                    <li>
                                        <a href="#">
                                            @if(session()->get('language') == 'bangla')
                                                আমাদের সম্পর্কে
                                            @else
                                                About Us
                                            @endif
                                            @if(get_pages_nav()->count() > 1)
                                                <i class="fi-rs-angle-down"></i>
                                            @endif
                                        </a>

                                        @if(get_pages_nav()->count() > 1)
                                            <ul class="sub-menu">
                                                @foreach(get_pages_nav()->skip(1) as $page)
                                                    <li>
                                                        <a href="{{ route('page.about', $page->slug) }}">
                                                            {{ $page->title }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <div class="header-action-icon-2 d-block d-lg-none">
                        <div class="burger-icon burger-icon-white">
                            <span class="burger-icon-top"></span>
                            <span class="burger-icon-mid"></span>
                            <span class="burger-icon-bottom"></span>
                        </div>
                    </div>
                    <div class="header-action-right d-block d-lg-none">
                        <div class="header-action-2">
                            <!--Mobile Header Search start-->
                            <a class="p-2 d-block text-reset active show">
                                <i class="fas fa-search la-flip-horizontal la-2x"></i>
                            </a>

                            <div class="advance-search">
                                <div class="search-box">
                                    <form action="{{ route('product.search') }}" method="post">
                                    @csrf
                                        <div class="input-group py-2">
                                            <span class="back_left hide"><i class="fas fa-long-arrow-left me-2"></i></span>
                                            <input class="header-search form-control search-field search" aria-label="Input group example" aria-describedby="btnGroupAddon" onfocus="search_result_show()" onblur="search_result_hide()" name="search" placeholder="Search here...">
                                            <button type="submit" class="input-group-text btn btn-sm" id="btnGroupAddon"><i class="fas fa-search"></i></button>
                                        </div>
                                    </form>
                                    <div class="shadow-lg searchProducts"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom-1 header-bottom-bg-color sticky-bar d-lg-none">
        <div class="container">
            <ul class="mobile-hor-swipe header-wrap header-space-between position-relative">
                @foreach(get_categories() as $category)
                    <li class="mb-10">
                        <a class="p-10" href="{{ route('product.category', $category->slug) }}">
                            @if(session()->get('language') == 'bangla')
                                {{ $category->name_bn }}
                            @else
                                {{ $category->name_en }}
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</header>
<!-- Mobile Side menu Start -->
<div class="mobile-header-active mobile-header-wrapper-style">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-top">
            <div class="mobile-header-logo">
                <a href="{{route('home')}}">
                    @php
                        $logo = get_setting('site_logo');
                    @endphp
                    @if($logo != null)
                        <img src="{{ asset(get_setting('site_logo')->value ?? 'null') }}" alt="{{ env('APP_NAME') }}">
                    @else
                        <img src="{{ asset('upload/no_image.jpg') }}" alt="{{ env('APP_NAME') }}" style="height: 60px !important; width: 80px !important; min-width: 80px !important;">
                    @endif
                </a>
            </div>
            <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                <button class="close-style search-close">
                    <i class="icon-top"></i>
                    <i class="icon-bottom"></i>
                </button>
            </div>
        </div>
        <div class="mobile-header-content-area">
            <div class="mobile-search search-style-3 mobile-header-border">
                <form action="{{ route('product.search') }}" method="post">
                    @csrf
                     <input class="header-search form-control search-field search" aria-label="Input group example" aria-describedby="btnGroupAddon" onfocus="search_result_show()" onblur="search_result_hide()" name="search" placeholder="Search for items…">
                    <button type="submit"><i class="fi-rs-search"></i></button>
                </form>
            </div>
            <div class="mobile-menu-wrap mobile-header-border">
                <!-- mobile menu start -->
                <nav>
                    <ul class="mobile-menu font-heading">
                        <li class="menu-item-has-children">
                            <a href="{{route('home')}}">Home</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="{{ route('product.show') }}">
                                @if(session()->get('language') == 'bangla')
                                    দোকান
                                @else
                                    Shop
                                @endif
                            </a>
                        </li>
                        @foreach (get_categories() as $category)
                            <li class="menu-item-has-children">
                                <a href="{{ route('product.category', $category->slug) }}">
                                    @if (session()->get('language') == 'bangla')
                                        {{ $category->name_bn }}
                                    @else
                                        {{ $category->name_en }}
                                    @endif
                                </a>
                                @if ($category->sub_categories && count($category->sub_categories) > 0)
                                    <ul class="dropdown">
                                        @foreach ($category->sub_categories as $subcategory)
                                            <li class="menu-item-has-children">
                                                <a href="{{ route('product.category', $subcategory->slug) }}">
                                                    @if (session()->get('language') == 'bangla')
                                                        {{ $subcategory->name_bn }}
                                                    @else
                                                        {{ $subcategory->name_en }}
                                                    @endif
                                                </a>
                                                @if ($subcategory->sub_sub_categories && count($subcategory->sub_sub_categories) > 0)
                                                    <ul class="dropdown">
                                                        @foreach ($subcategory->sub_sub_categories as $subsubcategory)
                                                            <li>
                                                                <a
                                                                    href="{{ route('product.category', $subsubcategory->slug) }}">
                                                                    @if (session()->get('language') == 'bangla')
                                                                        {{ $subsubcategory->name_bn }}
                                                                    @else
                                                                        {{ $subsubcategory->name_en }}
                                                                    @endif
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                        @foreach(get_pages_nav()->take(1) as $page)
                        <li class="menu-item-has-children">
                            <a href="{{ route('page.about', $page->slug) }}">
                                {{ $page->title }}
                            </a>
                        </li>
                        @endforeach
                        <li class="menu-item-has-children"><a href="{{ route('career')}}">Career</a></li>
                        <li class="menu-item-has-children">
                            <a href="#">
                                @if(session()->get('language') == 'bangla')
                                    আমাদের সম্পর্কে
                                @else
                                    About Us
                                @endif
                            </a>
                            @if(get_pages_nav()->count() > 1)
                                <ul class="dropdown">
                                    @foreach(get_pages_nav()->skip(1) as $page)
                                    <li>
                                        <a href="{{ route('page.about', $page->slug) }}">{{ $page->title }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>

                        <li class="menu-item-has-children">
                            <a href="#">Company Info</a>
                            <ul class="dropdown">
                                @foreach(get_pages_both_footer()->take(4) as $page)
                                <li>
                                    <a href="{{ route('page.about', $page->slug) }}">{{ $page->title }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">Language</a>
                            <ul class="dropdown">
                                @if(session()->get('language') == 'bangla')
                                    <li>
                                        <a href="{{ route('english.language') }}">English</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('bangla.language') }}">বাংলা</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- mobile menu end -->
            </div>
            <div class="mobile-header-info-wrap">
                <div class="single-mobile-header-info">
                    <a href="{{route('login')}}"><i class="fi-rs-user"></i>Log In </a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="{{route('register')}}"><i class="fi-rs-user"></i>Sign Up </a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="tel:{{ get_setting('phone')->value ?? ''}}"><i class="fi-rs-headphones"></i>{{ get_setting('phone')->value ?? '' }} </a>
                </div>
            </div>
            <div class="mobile-social-icon mb-50">
                <h6 class="mb-15">Follow Us</h6>
                <a href="{{ get_setting('facebook_url')->value ?? ''}}"><img src="{{asset('frontend/assets/imgs/theme/icons/icon-facebook-white.svg')}}" alt="facebook"></a>
                <a href="{{ get_setting('youtube_url')->value ?? ''}}"><img src="{{asset('frontend/assets/imgs/theme/icons/icon-twitter-white.svg')}}" alt="youtube"></a>
                <a href="{{ get_setting('twitter_url')->value ?? ''}}"><img src="{{asset('frontend/assets/imgs/theme/icons/icon-instagram-white.svg')}}" alt="twitter"></a>
                <a href="{{ get_setting('instagram_url')->value ?? ''}}"><img src="{{asset('frontend/assets/imgs/theme/icons/icon-pinterest-white.svg')}}" alt="instagram"></a>
                <a href="{{ get_setting('pinterest_url')->value ?? ''}}"><img src="{{asset('frontend/assets/imgs/theme/icons/icon-youtube-white.svg')}}" alt="pinterest"></a>
            </div>
            <div class="site-copyright">
                Copyright © 2023. All Rights Reserved By <a href="">{{ get_setting('copy_right')->value ?? '' }}</a>
            </div>
        </div>
    </div>
</div>

<!-- vendor Modal form -->
<div class="modal fade" id="vendor_service" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Vendor Apply Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('vendor.Sellerstore') }}" enctype="multipart/form-data">
                    @csrf
                    <h6 class="mb-2 border-bottom pb-2">Basic Information</h6>
                    <div class="form-group">
                        <label for="name"><strong>Name: </strong><span class="text-danger">*</span></label>
                        <input type="text" id="vendor_name" name="vendor_name" class="form-control"
                            placeholder="Enter Your Name" value="{{ old('vendor_name') }}">
                        @error('vendor_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone"><strong>Phone Number: </strong><span class="text-danger">*</span></label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                    placeholder="Enter Your Phone Number" value="{{ old('phone') }}">
                                @error('phone')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email"><strong>Email: </strong><span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="Enter Your Email" value="{{ old('email') }}">
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="mb-4">
                                    <img id="showImage3" class="rounded avatar-lg"
                                        src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                        alt="Card image cap" width="100px" height="80px;">
                                </div>
                                <label for="nid"><strong>Nid Card: </strong> <span class="text-danger">*</span></label>
                                <input name="nid" class="form-control" type="file" id="image3">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="mb-4">
                                    <img id="showImage4" class="rounded avatar-lg"
                                        src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                        alt="Card image cap" width="100px" height="80px;">
                                </div>
                                <label for="trade"><strong>Trade License(if any one have): </strong></label>
                                <input name="trade_license" class="form-control" type="file" id="image4">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password"><strong>Password : </strong><span
                                        class="text-danger">*</span></label>
                                <input class="form-control" id="password" type="password" name="password"
                                    placeholder="Enter Your Password">
                                @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cpassword"><strong>Confirm Password : </strong><span
                                        class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Confirm Password" type="password"
                                    name="password_confirmation" id="rtpassword" />
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <h6 class="mb-2 border-bottom pb-2">Shop Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shopname"><strong>Shop Name : </strong><span
                                        class="text-danger">*</span></label>
                                <input class="form-control" id="shop_name" type="text" name="shop_name"
                                    placeholder="Write vendor shop name" value="{{ old('shop_name') }}">
                                @error('shop_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address"><strong>Address : </strong></label>
                                <input class="form-control" id="address" type="text" name="address"
                                    placeholder="Enter Your Address" value="{{ old('address') }}">
                                @error('address')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="mb-4">
                                    <img id="showImage1" class="rounded avatar-lg"
                                        src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                        alt="Card image cap" width="100px" height="80px;">
                                </div>
                                <label for="image"><strong>Shop Profile : </strong></label>
                                <input name="shop_profile" class="form-control" type="file" id="image1">
                                @error('shop_profile')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="mb-4">
                                    <img id="showImage2" class="rounded avatar-lg"
                                        src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                        alt="Card image cap" width="100px" height="80px;">
                                </div>
                                <label for="image"><strong>Shop Cover Photo : </strong></label>
                                <input name="shop_cover" class="form-control" type="file" id="image2">
                                @error('shop_cover')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="shop"><strong>Bank Information</strong></label>
                        <textarea name="bank_information" id="bank_information" cols="30" rows="5" class="form-control"
                            placeholder="Enter Bank Information"></textarea>
                    </div>
                    <button type="submit" class="additional_menuBtn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Mobile Side menu End -->
<!--End header-->

@push('footer-script')
    <script>
        $("body").on("keyup", ".search", function() {
            let text = $(".search").val();
            let category_id = $("#searchCategory").val();

            if (text.length > 0) {
                $.ajax({
                    data: {
                        search: text,
                        category: category_id
                    },
                    url: "/search-product",
                    method: 'post',
                    beforeSend: function(request) {
                        request.setRequestHeader('X-CSRF-TOKEN', $("meta[name='csrf-token']").attr('content'));
                    },
                    success: function(result) {
                        $(".searchProducts").html(result);
                    }
                }); // end ajax
            } // end if

            if (text.length < 1) $(".searchProducts").html("");
        }); // end function

        /* ================ Advance Product slideUp/slideDown ============ */
        function search_result_hide(){
            $(".searchProducts").slideUp();
        }

        function search_result_show(){
            $(".searchProducts").slideDown();
        }
    </script>

    <script>
        $(document).ready(function(){
          $(".show").click(function(){
            $(".advance-search").show();
          });
          $(".hide").click(function(){
             $(".advance-search").hide();
          });
        });
    </script>
@endpush
