@extends('layouts.frontend')
@section('content-frontend')
@include('frontend.common.add_to_cart_modal')
<main class="main">
	<div class="container mb-30 mt-60">
	    <div class="row">
            <div class="row product-grid">
                @forelse($products as $product)
                    @include('frontend.common.product_grid_view')
                @empty
                    @if(session()->get('language') == 'bangla')
                        <h5 class="text-danger">এখানে কোন পণ্য খুঁজে পাওয়া যায়নি!</h5>
                    @else
                        <h5 class="text-danger">No products were found here!</h5>
                    @endif
                @endforelse
            </div>
	    </div>
	</div>
</main>
@endsection
