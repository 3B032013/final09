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
                        </form>


                    </div>
                </div>
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
