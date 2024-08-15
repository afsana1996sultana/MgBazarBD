<style>
    .card {
        background-color: #fff;
        padding: 15px;
        border: none
    }
    .input-box {
        position: relative
    }
    .input-box i {
        position: absolute;
        right: 13px;
        top: 15px;
        color: #ced4da
    }
    .form-control {
        height: 50px;
        background-color: #eeeeee69
    }
    .form-control:focus {
        background-color: #eeeeee69;
        box-shadow: none;
        border-color: #eee
    }
    .list {
        padding-top: 20px;
        padding-bottom: 10px;
        display: flex;
        align-items: center
    }
    .border-bottom {
        border-bottom: 2px solid #eee;
    }
    .list i {
        font-size: 19px;
        color: red
    }
    .list small {
        color: #dedddd

    }
    .price{
        font-size: 18px;
        font-weight: bold;
        color: #3BB77E;
    }
    .old-price{
        font-size: 14px;
        color: #adadad;
        margin: 0 0 0 7px;
        text-decoration: line-through;
    }

    </style>

    @if($brands -> isEmpty())
        <h5 class="text-center text-danger p-4">Brand Not Found </h5>
    @else

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @foreach($brands as $brand)
                    <a href="{{ route('product.brand', $brand->slug) }}">
                        @if($loop->index == (count($brands) - 1))
                            <div class="list">
                                <img src="{{ asset($brand->brand_image) }}" style="width: 30px; height: 30px;">
                                <div class="d-flex flex-column ml-3" style="margin-left: 10px;"> <span style="color: black;">{{ $brand->name_en }} </span>
                                </div>
                            </div>
                        @else
                            <div class="list border-bottom">
                                <img src="{{ asset($brand->brand_image) }}" style="width: 30px; height: 30px;">
                            </div>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
