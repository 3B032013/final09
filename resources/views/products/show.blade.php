@extends('products.show.layouts.master')

@section('title','商品內容')

@section('content')
<hr>
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="{{ asset('storage/products/' . $product->image_url) }}" alt="..." /></div>
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
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Related items section-->
{{--<section class="py-5 bg-light">--}}
{{--    <div class="container px-4 px-lg-5 mt-5">--}}
{{--        <h2 class="fw-bolder mb-4">Related products</h2>--}}
{{--        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">--}}
{{--            <div class="col mb-5">--}}
{{--                <div class="card h-100">--}}
{{--                    <!-- Product image-->--}}
{{--                    <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />--}}
{{--                    <!-- Product details-->--}}
{{--                    <div class="card-body p-4">--}}
{{--                        <div class="text-center">--}}
{{--                            <!-- Product name-->--}}
{{--                            <h5 class="fw-bolder">Fancy Product</h5>--}}
{{--                            <!-- Product price-->--}}
{{--                            $40.00 - $80.00--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- Product actions-->--}}
{{--                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">--}}
{{--                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View options</a></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col mb-5">--}}
{{--                <div class="card h-100">--}}
{{--                    <!-- Sale badge-->--}}
{{--                    <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>--}}
{{--                    <!-- Product image-->--}}
{{--                    <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />--}}
{{--                    <!-- Product details-->--}}
{{--                    <div class="card-body p-4">--}}
{{--                        <div class="text-center">--}}
{{--                            <!-- Product name-->--}}
{{--                            <h5 class="fw-bolder">Special Item</h5>--}}
{{--                            <!-- Product reviews-->--}}
{{--                            <div class="d-flex justify-content-center small text-warning mb-2">--}}
{{--                                <div class="bi-star-fill"></div>--}}
{{--                                <div class="bi-star-fill"></div>--}}
{{--                                <div class="bi-star-fill"></div>--}}
{{--                                <div class="bi-star-fill"></div>--}}
{{--                                <div class="bi-star-fill"></div>--}}
{{--                            </div>--}}
{{--                            <!-- Product price-->--}}
{{--                            <span class="text-muted text-decoration-line-through">$20.00</span>--}}
{{--                            $18.00--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- Product actions-->--}}
{{--                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">--}}
{{--                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col mb-5">--}}
{{--                <div class="card h-100">--}}
{{--                    <!-- Sale badge-->--}}
{{--                    <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>--}}
{{--                    <!-- Product image-->--}}
{{--                    <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />--}}
{{--                    <!-- Product details-->--}}
{{--                    <div class="card-body p-4">--}}
{{--                        <div class="text-center">--}}
{{--                            <!-- Product name-->--}}
{{--                            <h5 class="fw-bolder">Sale Item</h5>--}}
{{--                            <!-- Product price-->--}}
{{--                            <span class="text-muted text-decoration-line-through">$50.00</span>--}}
{{--                            $25.00--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- Product actions-->--}}
{{--                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">--}}
{{--                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col mb-5">--}}
{{--                <div class="card h-100">--}}
{{--                    <!-- Product image-->--}}
{{--                    <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />--}}
{{--                    <!-- Product details-->--}}
{{--                    <div class="card-body p-4">--}}
{{--                        <div class="text-center">--}}
{{--                            <!-- Product name-->--}}
{{--                            <h5 class="fw-bolder">Popular Item</h5>--}}
{{--                            <!-- Product reviews-->--}}
{{--                            <div class="d-flex justify-content-center small text-warning mb-2">--}}
{{--                                <div class="bi-star-fill"></div>--}}
{{--                                <div class="bi-star-fill"></div>--}}
{{--                                <div class="bi-star-fill"></div>--}}
{{--                                <div class="bi-star-fill"></div>--}}
{{--                                <div class="bi-star-fill"></div>--}}
{{--                            </div>--}}
{{--                            <!-- Product price-->--}}
{{--                            $40.00--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- Product actions-->--}}
{{--                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">--}}
{{--                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}


{{--<div class="flex font-sans">--}}
{{--    <div class="flex-none w-48 relative">--}}
{{--        <img src="{{ asset('storage/products/' . $product->image_url) }}" alt="" class="absolute inset-0 w-full h-full object-cover" loading="lazy" />--}}
{{--    </div>--}}
{{--    <form class="flex-auto p-6">--}}
{{--        <div class="flex flex-wrap">--}}
{{--            <h1 class="flex-auto text-lg font-semibold text-slate-900">{{ $product->name }}</h1>--}}
{{--            <div class="text-lg font-semibold text-slate-500">${{ $product->price }}</div>--}}
{{--        </div>--}}
{{--        <div class="flex space-x-4 mb-6 text-sm font-medium">--}}
{{--            <div class="flex-auto flex space-x-4">--}}
{{--                <div class="form-group">--}}
{{--                    <input id="num" name="num" type="text" class="form-control">--}}
{{--                    <form action="{{ route("cart_items.store",$product->id) }}" method="POST" role="form">--}}
{{--                        @csrf--}}
{{--                        @method('POST')--}}
{{--                        <button type="submit" class="btn btn-secondary">加入購物車</button>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <p class="text-sm text-slate-700">--}}
{{--            {{ $product->content }}--}}
{{--        </p>--}}
{{--    </form>--}}
{{--</div>--}}

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
