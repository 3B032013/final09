@extends('products.index.layouts.master')

@section('title','電腦二手零件交易平台')

@section('content')
    <div class="container px-4 px-lg-5 mt-2 mb-4">
        <form action="{{ route('products.search') }}" method="GET" class="d-flex">
            <input type="text" name="query" class="form-control me-2" placeholder="關鍵字搜尋...">
            <button type="submit" class="btn btn-outline-dark">搜尋</button>
        </form>
    </div>
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            @if (count($products) > 0)
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    @php
                        $count =0;
                    @endphp
                    @foreach($products as $key => $product)
                        <div class="col mb-5">
                            <div class="card h-100">
                                <!-- Product image-->
                                <a href="{{ route("products.show",$product->id) }}">
                                    <img class="card-img-top" src="{{ asset('storage/products/' . $product->image_url) }}" alt="{{ $product->title }}" style="max-width: 150%; height: 250px" />
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
{{--                                @for ($i = 5; $i >= 1; $i--)--}}
{{--                                    <input type="radio" id="star{{ $i }}" name="comment_rating_{{ $count }}" value="{{ $i }}" {{ old('buyer_rating', number_format($averageScores[$key], 0)) == $i ? 'checked' : '' }} disabled>--}}
{{--                                    <label for="star{{ $i }}"><i class="fas fa-star"></i></label>--}}
{{--                                @endfor--}}
                                <div align="center">
                                    @if (isset($averageScores[$key+1]))
                                        <div class="rating d-flex justify-content-center mb-4">
                                            @for ($i = 5; $i >= 1; $i--)
                                                <input type="radio" id="star{{ $i }}" name="comment_rating_{{ $count }}" value="{{ $i }}" {{ old('buyer_rating', number_format($averageScores[$key+1], 0)) == $i ? 'checked' : '' }} disabled>
                                                <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                            @endfor
                                        </div>
                                    @else
                                        <p>尚無評分</p>
                                    @endif
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-3 pt-0 border-top-0 bg-transparent d-flex justify-content-center align-items-center">
                                    <form action="{{ route("cart_items.store",$product->id) }}" method="POST" role="form">
                                        @csrf
                                        @method('POST')
                                        <span class="quantity-span">
                                        <button class="quantity-minus" type="button">-</button>
                                        <input class="quantity-input" type="text" min="1" name="quantity" value="1" style="max-width: 5rem">
                                        <button class="quantity-plus" type="button">+</button>
                                        </span>
                                        <br><br><div class="text-center"><button class="btn btn-outline-dark mx-6 mt-auto" type="submit">加入購物車</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @php
                            $count +=1;
                        @endphp
                    @endforeach
                </div>
                <div class="d-flex justify-content-center">
                    @if ($products->currentPage() > 1)
                        <a href="{{ $products->previousPageUrl() }}" class="btn btn-secondary">上一頁</a>
                    @endif

                    <span class="mx-2">全部 {{ $products->total() }} 筆商品，目前位於第 {{ $products->currentPage() }} 頁，共 {{ $products->lastPage() }} 頁</span>

                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="btn btn-secondary">下一頁</a>
                    @endif
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

