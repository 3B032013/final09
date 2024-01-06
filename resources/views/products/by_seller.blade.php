@extends('products.by_seller.layouts.master')

@section('title',$seller->user->name.' - 賣場')

@section('page-path')
    <div>
        <p style="font-size: 1.2em;">
            <a href="{{ route('home') }}"><i class="fa fa-home"></i></a> &gt;
            {{ $seller->user->name }}賣場
        </p>
    </div>
@endsection

@section('content')
<div class="container px-4 px-lg-5 mt-2 mb-4">
    <form action="{{ route('products.by_seller.search',['seller_id' => $seller->id]) }}" method="GET" class="d-flex">
        <input type="text" name="query" class="form-control me-2" placeholder="關鍵字搜尋...">
        <button type="submit" class="btn btn-outline-dark">搜尋</button>
    </form>
</div>
<!-- Page Content-->
<div class="container px-4 px-lg-5">
    <!-- Heading Row-->
    <div class="row gx-4 gx-lg-5 align-items-center my-5">
        <div class="row">
            <div class="col-lg-7 d-flex align-items-center">
                <div class="rounded-circle overflow-hidden" style="width: 200px; height: 200px;">
                    @if ($seller->user->photo == 'head.jpg')
                        <img class="card-img-top w-100 h-100 object-cover" src="{{ asset('images/head.jpg') }}" alt="{{ htmlspecialchars($seller->user->name) }}" />
                    @else
                        <img class="card-img-top w-100 h-100 object-cover" src="{{ asset('storage/user/' . $seller->user->photo) }}" alt="{{ htmlspecialchars($seller->user->name) }}" />
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                <h1 class="font-weight-light">{{ $seller->user->name }}</h1>
                <p>歡迎來到我的賣場</p>
            </div>
        </div>
    </div>

{{--    <table class="mx-auto" border="0">--}}
{{--        <thead>--}}
{{--        <tr align="center">--}}
{{--            @foreach ($sellerCategories as $category)--}}
{{--                <th width="200" height="30">--}}
{{--                    <form action="{{ route('products.by_seller', ['seller_id' => $seller->id]) }}" method="GET">--}}
{{--                        @method('GET')--}}
{{--                        <input type="hidden" name="seller_id" value="{{ $seller->id }}">--}}
{{--                        @if(isset($category_id))--}}
{{--                            <input type="hidden" name="category_id" value="">--}}
{{--                            <button type="submit" class="button">選擇所有商品</button>--}}
{{--                        @else--}}
{{--                                <input type="hidden" name="category_id" value="{{ $category->id }}">--}}
{{--                            <button type="submit" class="button">{{$category->name}}</button>--}}
{{--                            <button type="submit" class="button" name="category_id" value="{{ $category->id }}">--}}
{{--                                {{$category->name}}--}}
{{--                            </button>--}}
{{--                        @endif--}}
{{--                    </form>--}}
{{--                </th>--}}
{{--            @endforeach--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--    </table>--}}

    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            @if (count($products) > 0)
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    @foreach($products as $product)

                        <div class="col mb-5">
                            <div class="card h-100">
                                <!-- Product image-->
                                <a href="{{ route("products.show",$product->id) }}">
                                    <img class="card-img-top" src="{{ asset('storage/products/' . $product->image_url) }}" alt="{{ $product->title }}" style="max-width: 100%; height: 250px" />
                                </a>
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder">{{ $product->name }}</h5>
                                        <!-- Product price-->
                                        <span class="price" style="color: red; font-size: 1.6em; font-weight: bold;">${{ $product->price }}</span>
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-3 pt-0 border-top-0 bg-transparent d-flex justify-content-center align-items-center">
                                    <form action="{{ route("cart_items.store",$product->id) }}" method="POST" role="form">
                                        @csrf
                                        @method('POST')
                                        <span class="quantity-span">
                            <button class="quantity-minus" type="button">-</button>
                            <input class="quantity-input" type="text"  name="quantity" value="1" style="max-width: 5rem">
                            <button class="quantity-plus" type="button">+</button>
                            </span>
                                        <br><br><div class="text-center"><button class="btn btn-outline-dark mx-6 mt-auto" type="submit">加入購物車</button></div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div align="center">
                    <h3>賣場內無商品</h3>
                </div>
            @endif
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantitySpans = document.querySelectorAll('.quantity-span');

            quantitySpans.forEach(span => {
                const quantityInput = span.querySelector('.quantity-input');
                const minusButton = span.querySelector('.quantity-minus');
                const plusButton = span.querySelector('.quantity-plus');

                minusButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    updateQuantity(quantityInput, -1);
                });

                plusButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    updateQuantity(quantityInput, 1);
                });
            });

            function updateQuantity(input, change) {
                let newValue = parseInt(input.value) + change;
                if (newValue < 1) {
                    newValue = 1;
                }
                input.value = newValue;
            }
        });
    </script>
@endsection

    <style>
        .button {
            display: inline-block;
            outline: 0;
            border: 0;
            cursor: pointer;
            background-color: white;
            border-radius: 4px;
            padding: 8px 16px;
            font-size: 16px;
            font-weight: 600;
            color: #2d3748;
            border: 1px solid #cbd5e0;
            line-height: 26px;
            box-shadow: 0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06);
        }
    </style>

