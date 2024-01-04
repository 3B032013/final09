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
                    </div>
                    <table border="0">
                        <tr>
                            <td>
                                <div class="rating d-flex justify-content-center mb-4">
                                    @php
                                        $count = 0
                                    @endphp
                                    @for ($i = 5; $i >= 1; $i--)
                                        @php
                                            $count += 1
                                        @endphp
                                        <input type="radio" id="star{{ $i }}" name="comment_rating" value="{{ $i }}" {{ old('averageScore', number_format($averageScore,0)) == $i ? 'checked' : '' }} disabled>
                                        <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                    @endfor
                                </div>
                            </td>
                        </tr>
                    </table><br><br><br><br><br><br><br><br><br><br><br><br>
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
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container">
            {{-- Display the overall title --}}
            <div class="text-center mb-4">
                <h2>買家評論</h2>
            </div>
            @php
                $count =0;
            @endphp
            {{-- Display all posts --}}
            @if(count($AllMessages) > 0)
                <div class="row">
                    @foreach($AllMessages as $message)
                        <div class="col-md-6 mb-4 mx-auto">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $message->order->user->name }}：</h5>
                                    {{ $message->buyer_message }}
                                    <div class="rating d-flex justify-content-center mb-4">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{ $i }}" name="comment_rating_{{ $count }}" value="{{ $i }}" {{ old('buyer_rating', number_format($message->buyer_rating, 0)) == $i ? 'checked' : '' }} disabled>
                                            <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                        @endfor
                                    </div>
                                    <p class="card-text"><small class="text-muted">評論日期： {{ $message->updated_at }}</small></p>
                                </div>
                            </div>
                        </div>
                        @php
                            $count +=1;
                        @endphp
                    @endforeach
                </div>
            @else
                <div align="center"><p>目前無評論</p></div>
            @endif
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

    <script>
        function previewImage(input) {
            var preview = document.getElementById('image-preview');
            var file = input.files[0];
            var reader = new FileReader();
            reader.onloadend = function () {
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        }
    </script>
    <style>
        .rating {
            display: flex;
            flex-direction: row-reverse;
        }

        .rating input {
            display: none;
        }

        .rating label {
            cursor: pointer;
            font-size: 1.5em;
            color: #ddd;
        }

        .rating input:checked ~ label {
            color: #ffc107;
        }
    </style>
@endsection
