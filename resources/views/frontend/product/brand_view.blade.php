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
                                {{ $brands->name_bn }}
                            @else
                                {{ $brands->name_en }}
                            @endif
                        </h1>
                        <div class="breadcrumb">
                            <a href="{{ route('home')}}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                            <span></span>
                            @if(session()->get('language') == 'bangla')
                                {{ $brands->name_bn }}
                            @else
                                {{ $brands->name_en }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mb-30">
        <div class="row">
            <div class="col-xl-9">
                <div class="row product-grid">
                	@forelse($products as $product)
                        @include('frontend.common.product_grid_view',['product' => $product])
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
            <div class="col-xl-3 primary-sidebar sticky-sidebar">
                <!-- Fillter By Price -->
                @include('frontend.common.filterby')
            	<!-- SideCategory -->
                @include('frontend.common.sidecategory')
            </div>
        </div>
    </div>
</main>
@endsection
@push('footer-script')
    <script>
        function updateBrandId(value) {
            document.getElementById('brand_id').value = value;
        }

        function updateSortBy(value) {
            document.getElementById('sort_by').value = value;
        }

        function filter() {
            document.getElementById('search-form').submit();
        }
    </script>

    <script type="text/javascript">
        function sort_price_filter(){
           var start = $('#slider-range-value1').html();
           var end = $('#slider-range-value2').html();
           $('#filter_price_start').val(start);
           $('#filter_price_end').val(end);
           $('#search-form').submit();
        }
    </script>

    <script type="text/javascript">
        (function ($) {
            ("use strict");
            // Slider Range JS
            if ($("#slider-range").length) {
                $(".noUi-handle").on("click", function () {
                    $(this).width(50);
                });
                var rangeSlider = document.getElementById("slider-range");
                var moneyFormat = wNumb({
                    decimals: 0,
                });
                var start_price = document.getElementById("filter_price_start").value;
                var end_price = document.getElementById("filter_price_end").value;
                noUiSlider.create(rangeSlider, {
                    start: [start_price, end_price],
                    step: 1,
                    range: {
                        min: [1],
                        max: [5000]
                    },
                    format: moneyFormat,
                    connect: true
                });

                // Set visual min and max values and also update value hidden form inputs
                rangeSlider.noUiSlider.on("update", function (values, handle) {
                    document.getElementById("slider-range-value1").innerHTML = values[0];
                    document.getElementById("slider-range-value2").innerHTML = values[1];
                    document.getElementsByName("min-value").value = moneyFormat.from(values[0]);
                    document.getElementsByName("max-value").value = moneyFormat.from(values[1]);
                });

            }
        })(jQuery);
    </script>
@endpush
