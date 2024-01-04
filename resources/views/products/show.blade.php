@extends('products.show.layouts.master')

@section('title','商品內容')

@section('content')
    <hr>
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="{{ asset('storage/products/' . $product->image_url) }}" alt="..." style="max-width: 500%; height: 650px"/></div>
                <div class="col-md-6">
                    <h1 class="display-5 fw-bolder">{{ $product->name }}</h1>
                    <div class="fs-5 mb-5">
                        {{--                    <span class="text-decoration-line-through">$45.00</span>--}}
                        <span>${{ $product->price }}</span>
                    </div><br><br><br><br><br><br><br><br>
                    <p class="lead">{{ $product->content }}</p>
                    <div class="d-flex">
                        <form action="{{ route("cart_items.store",$product->id) }}" method="POST" role="form">
                            @csrf
                            @method('POST')
                            <span class="quantity-span">
                        <button class="quantity-minus" type="button">-</button>
                        <input class="quantity-input" type="text"  name="quantity" value="1" style="max-width: 5rem">
                        <button class="quantity-plus" type="button">+</button>
                        </span>
                            {{--                        <input class="form-control text-center me-3" id="inputQuantity" name="quantity" type="number" value="1" style="max-width: 3rem">--}}
                            <br><br><button class="btn btn-outline-dark flex-shrink-0" type="submit">
                                加入購物車
                            </button>
                            庫存量：{{ $product->inventory }}
                        </form>
                    </div>
                </div>
                <div class="border p-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle overflow-hidden" style="width: 150px; height: 150px;">
                            @if ($product->seller->user->photo == 'head.jpg')
                                <img class="card-img-top w-100 h-100 object-cover" src="{{ asset('images/head.jpg') }}" alt="{{ htmlspecialchars($product->seller->user->name) }}" />
                            @else
                                <img class="card-img-top w-100 h-100 object-cover" src="{{ asset('storage/user/' . $product->seller->user->photo) }}" alt="{{ htmlspecialchars($product->seller->user->name) }}" />
                            @endif
                        </div>
                        <div class="ml-3">
                            <span>賣家：{{ $product->seller->user->name }} 賣場</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <span>商品數量：{{ $productsCount }} </span><br>
                            <a href="{{ route("products.by_seller",$product->seller_id) }}">
                                查看賣場
                            </a>
                        </div>
                        <div class="m-lg-4">

                        </div>
                    </div>
                </div>

            </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="fw-bolder mb-4">相關商品</h2>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach ($relatedProducts as $relatedProduct)
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <a href="{{ route("products.show",$relatedProduct->id) }}">
                                <img class="card-img-top" src="{{ asset('storage/products/' . $relatedProduct->image_url) }}" alt="..." style="max-width: 150%; height: 250px" />
                            </a>
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{ $relatedProduct->name }}</h5>
                                    <!-- Product price-->
                                    ${{ $relatedProduct->price }}
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <form action="{{ route("cart_items.addToCart",$relatedProduct->id) }}" method="POST" role="form">
                                        @csrf
                                        @method('POST')
                                        <div class="text-center"><button class="btn btn-outline-dark mx-6 mt-auto" type="submit">加入購物車</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
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
