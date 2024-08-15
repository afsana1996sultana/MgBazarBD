@extends('layouts.frontend')
@section('content-frontend')
@include('frontend.common.add_to_cart_modal')
<main class="main">
    <div class="page-header mt-30 mb-50">
        <div class="container">
            <div class="archive-header">
                <div class="row align-items-center">
                    <div class="col-xl-3">
                        <h1 class="mb-15">
                        	@if(session()->get('language') == 'bangla') 
                                {{ $tag->name_bn }}
                            @else 
                                {{ $tag->name_en }} 
                            @endif
                        </h1>
                        <div class="breadcrumb">
                            <a href="{{ route('home')}}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                            <span></span>@if(session()->get('language') == 'bangla') 
                                {{ $tag->name_bn }}
                            @else 
                                {{ $tag->name_en }} 
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-9 text-end d-none d-xl-block">
                    	
                        <ul class="tags-list">
                        	@forelse($tags as $tag)
                            <li class="hover-up">
                                <a href="{{ url('tag-product/'.$tag->id.'/'.$tag->tag_slug_en) }}">
                                	<i class="fi-rs-cross mr-10"></i>
                                	@if(session()->get('language') == 'bangla') 
	                                    {{ $tag->name_bn }}
	                                @else 
	                                    {{ $tag->name_en }} 
	                                @endif
                                </a>
                            </li>
                            @empty
			                    @if(session()->get('language') == 'bangla') 
			                        <h5 class="text-danger">এখানে কোন পণ্য খুঁজে পাওয়া যায়নি!</h5> 
			                    @else 
			                       <h5 class="text-danger">No products were found here!</h5> 
			                    @endif
	                  		@endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mb-30">
        <div class="row">
            <div class="col-lg-4-5">
                <div class="shop-product-fillter">
                    <div class="totall-product">
                        <p>We found <strong class="text-brand">{{ count($products) }}</strong> items for you!</p>
                    </div>
                    <div class="sort-by-product-area">
                        <div class="sort-by-cover mr-10">
                            <div class="sort-by-product-wrap">
                                <div class="sort-by">
                                    <span><i class="fi-rs-apps"></i>Show:</span>
                                </div>
                                <div class="sort-by-dropdown-wrap">
                                    <span> 50 <i class="fi-rs-angle-small-down"></i></span>
                                </div>
                            </div>
                            <div class="sort-by-dropdown">
                                <ul>
                                    <li><a class="active" href="#">50</a></li>
                                    <li><a href="#">100</a></li>
                                    <li><a href="#">150</a></li>
                                    <li><a href="#">200</a></li>
                                    <li><a href="#">All</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="sort-by-cover">
                            <div class="sort-by-product-wrap">
                                <div class="sort-by">
                                    <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                </div>
                                <div class="sort-by-dropdown-wrap">
                                    <span> Featured <i class="fi-rs-angle-small-down"></i></span>
                                </div>
                            </div>
                            <div class="sort-by-dropdown">
                                <ul>
                                    <li><a class="active" href="#">Featured</a></li>
                                    <li><a href="#">Price: Low to High</a></li>
                                    <li><a href="#">Price: High to Low</a></li>
                                    <li><a href="#">Release Date</a></li>
                                    <li><a href="#">Avg. Rating</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row product-grid">
                	@forelse($products as $product)
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="product-cart-wrap mb-30">
                            <div class="product-img-action-wrap">
                                <div class="product-img product-img-zoom">
                                    <a href="shop-product-right.html">
                                        <img class="default-img" src="{{asset($product->product_thumbnail)}}" alt="product thumbnail">
                                        <img class="hover-img" src="assets/imgs/shop/product-1-2.jpg" alt="product thumbnail">
                                    </a>
                                </div>
                                <div class="product-action-1 d-flex">
                                    <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                    <a aria-label="Compare" class="action-btn" href="#"><i class="fi-rs-shuffle"></i></a>
                                    <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                </div>
                                <div class="product-badges product-badges-position product-badges-mrg">
                                    @php
			                            $amount = $product->regular_price - $product->discount_price;
			                            $discount = ($amount/$product->regular_price) * 100;
	                          		@endphp

                                    @if ($product->discount_price == NULL)
                                		<span class="hot">Hot</span>
		                            @else
		                             	<span class="hot">{{ round($discount) }}%</span>
		                            @endif
                                </div>
                            </div>
                            <div class="product-content-wrap">
                                <div class="product-category">
                                    <a href="#">
                                    	@if(session()->get('language') == 'bangla') 
			                                {{ $tag->name_bn }}
			                            @else 
			                                {{ $tag->name_en }} 
			                            @endif
                                    </a>
                                </div>
                                <h2>
                                	<a href="{{ url('product-details/'.$product->id.'/'.$product->product_slug_en ) }}">
                                		@if(session()->get('language') == 'bangla') 
                                            {{
                                            	$product->name_bn 
                                            }}
                                        @else 
                                            {{
                                            	$product->name_en 
                                            }} 
                                        @endif
                                	</a>
                                </h2>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (0)</span>
                                </div>
                                <div class="product-card-bottom">
                                    <div class="product-price">
                                        @if ($product->discount_price == NULL)
			                                <div class="product-price">
			                                	<span class="price"> ৳{{ $product->regular_price }} </span>
			                                </div>
			                            @else
			                               <div class="product-price">
			                                  	<span class="price"> ৳{{ $product->discount_price }} </span>
			                                  	<span class="old-price">৳ {{ $product->regular_price }}</span>
			                                </div>
			                            @endif
                                    </div>
                                    <div class="add-cart">
                                        <a class="add" href="#" id="{{ $product->id }}" onclick="productView(this.id)" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
	                @empty
                        @if(session()->get('language') == 'bangla') 
	                        <h5 class="text-danger">এখানে কোন পণ্য খুঁজে পাওয়া যায়নি!</h5> 
	                    @else 
	                       	<h5 class="text-danger">No products were found here!</h5> 
	                    @endif
	                @endforelse
                    <!--end product card-->
                </div>
                <!--product grid-->
                <div class="pagination-area mt-20 mb-20">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            {{ $products->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-lg-1-5 primary-sidebar sticky-sidebar">
                <!-- Fillter By Price -->
                @include('frontend.common.filterby')
            	<!-- SideCategory -->
                @include('frontend.common.sidecategory')
            </div>
        </div>
    </div>
</main>
@endsection