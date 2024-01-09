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
                    @foreach($products as $product)
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
                                <!-- Product actions-->
                                <div class="card-footer p-3 pt-0 border-top-0 bg-transparent d-flex justify-content-center align-items-center">
                                    <form action="{{ route("cart_items.store",$product->id) }}" method="POST" role="form">
                                        @csrf
                                        @method('POST')
                                        <span class="quantity-span">
                                            <button class="quantity-minus" data-product-id="{{ $product->id }}" type="button">-</button>
                                            <input class="quantity-input" data-product-id="{{ $product->id }}" type="text" min="1" max="{{ $product->inventory }}" name="quantity" value="1" style="max-width: 5rem" oninput="checkQuantity(this)">
                                            <button class="quantity-plus" data-product-id="{{ $product->id }}" type="button">+</button>
                                        </span>
                                        <br><br><div class="text-center"><button class="btn btn-outline-dark mx-6 mt-auto" type="submit">加入購物車</button></div>
                                    </form>

                                </div>
                            </div>
                        </div>
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

