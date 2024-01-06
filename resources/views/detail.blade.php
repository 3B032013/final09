@extends('products.index.layouts.master')

@section('title','二手書拍賣平台')

@section('content')

    <h1  style="text-align: center;"><a class="text-black-50 mb-2" href="#firstOrder" >第一次下單</a></h1>
    <h1  style="text-align: center;"><a class="text-black-50 mb-2" href="#firstSell">第一次賣商品</a></h1>



    <p id="firstOrder">這是第一次下單的內容。</p>
    <img class="card-img-top w-100 h-100 object-cover" src="{{ asset('images/第一次下單.jpg') }}" alt="{{ "找不到圖片" }}" />

    <!-- 第一次賣書的段落 -->
    <p id="firstSell">這是第一次賣商品的內容。</p>
    <img class="card-img-top w-100 h-100 object-cover" src="{{ asset('images/第一次賣商品.jpg') }}" alt="{{ "找不到圖片" }}" />

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

