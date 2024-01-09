@extends('products.show.layouts.master')

@section('title','商品檢視 - '.$product->name)

@section('page-path')
    @if (session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif
    <div>
        <p style="font-size: 1.2em;"><a href="{{ route('home') }}">
            <i class="fa fa-home"></i></a> &gt;
            {{ $product->name }}
        </p>
    </div>
@endsection

@section('content')
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
                                    @if(count($AllMessages) > 0)
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
                                    @else
                                        <div align="center"><p>目前無評論</p></div>
                                    @endif
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
                                <button class="quantity-minus" data-product-id="{{ $product->id }}" type="button">-</button>
                                <input class="quantity-input" data-product-id="{{ $product->id }}" type="text" min="1" max="{{ $product->inventory }}" name="quantity" value="1" style="max-width: 5rem" oninput="checkQuantity(this)">
                                <button class="quantity-plus" data-product-id="{{ $product->id }}" type="button">+</button>
                            </span>
                            <br><br><button class="btn btn-outline-dark flex-shrink-0" type="submit">
                                加入購物車
                            </button>
                            庫存量：{{ $product->inventory }}
                        </form>
                    </div><br>
                    <div class="d-flex">
                        <form id="directPurchaseForm" action="{{ route('orders.show_create') }}" method="GET">
                            @csrf
                            @method('GET')
                            <button class="btn btn-outline-dark flex-shrink-0" type="button" onclick="directPurchase()">直接購買</button>
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
                    </div>
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
        function checkQuantity(input) {
            // 獲取輸入框的值
            let newValue = parseInt(input.value);

            // 獲取庫存範圍
            let maxInventory = parseInt(input.getAttribute('max'));
            let minInventory = parseInt(input.getAttribute('min'));

            // 如果輸入值不是一個有效的數字，或者超出庫存範圍，進行相應處理
            if (isNaN(newValue) || newValue < minInventory || newValue > maxInventory) {
                // 顯示警告或執行其他處理方式，例如將數量重置為庫存範圍內的值
                alert('輸入超過庫存數量!');
                input.value = Math.min(Math.max(newValue, minInventory), maxInventory);
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantitySpans = document.querySelectorAll('.quantity-span');

            quantitySpans.forEach(span => {
                const quantityInput = span.querySelector('.quantity-input');
                const minusButton = span.querySelector('.quantity-minus');
                const plusButton = span.querySelector('.quantity-plus');
                const productId = quantityInput.getAttribute('data-product-id'); // 獲取商品 ID

                minusButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    updateQuantity(quantityInput, -1, productId);
                });

                plusButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    updateQuantity(quantityInput, 1, productId);
                });
            });

            function updateQuantity(input, change, productId) {
                let newValue = parseInt(input.value) + change;

                if (newValue < 1) {
                    newValue = 1;
                }

                // 在這裡你可以使用 productId，執行與商品相關的操作，例如檢查是否超過庫存
                // 如果你的商品信息需要從後端獲取，你可能需要進行 Ajax 請求來獲取該商品的庫存等信息

                // 檢查是否超過庫存
                if (input.getAttribute('max') && newValue > parseInt(input.getAttribute('max'))) {
                    newValue = parseInt(input.getAttribute('max'));
                    // 可以顯示提示或採取其他處理方式，例如禁用按鈕
                    alert('超過庫存數量！');
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
    <script>
        function directPurchase() {
            // 收集所需的商品信息
            const selectedItems = '{{ $product->id }}';  // 這裡使用了商品詳細頁的範例，你可能需要根據實際情況調整

            // 在表單中添加一個隱藏字段，用於傳遞所選商品的信息
            const selectedItemsInput = document.createElement('input');
            selectedItemsInput.type = 'hidden';
            selectedItemsInput.name = 'selected_items';
            selectedItemsInput.value = selectedItems;

            // 將隱藏字段添加到表單中
            document.getElementById('directPurchaseForm').appendChild(selectedItemsInput);

            // 提交表單
            document.getElementById('directPurchaseForm').submit();
        }
    </script>
@endsection
