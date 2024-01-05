@extends('products.index.layouts.master')

@section('title', '購物車')

@section('content')
    <div class="wrapper">
        <div class="container mt-8">
            <h1 class="text-2xl mb-4" align="center">購物車內容</h1>

            @if ($cartItems->count() > 0)
                @php
                    $cartItemsBySeller = $cartItems->groupBy('product.seller.id');
                    $totalAmount = 0;
                @endphp

                @foreach ($cartItemsBySeller as $sellerId => $items)
                    @php
                        $seller = $items->first()->product->seller;
                        $totalAmountBySeller = 0;
                    @endphp

                        <table class="mx-auto" border="0">
                        <tbody>
                        <tr>
                            <td class="py-2 px-4 border-b" colspan="7">
                                賣家：{{ $seller->user->name }}
                            </td>
                        </tr>
                        @foreach ($items as $cartItem)
                            <tr>
                                <td class="py-2 px-4 border-b">
                                    <input type="checkbox" style="transform: scale(1.5)" name="selected_items[]" checked value="{{ $cartItem->id }}">
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <img src="{{ asset('storage/products/' . $cartItem->product->image_url) }}" alt="{{ $cartItem->product->name }}" width="150px" height="150px">
                                </td>
                                <td class="py-2 px-4 border-b">{{ $cartItem->product->name }}</td>
                                <td class="py-2 px-4 border-b price" data-price="{{ $cartItem->product->price }}">
                                    ${{ $cartItem->product->price }}
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <form action="{{ route('cart_items.quantity_minus', $cartItem->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <span class="quantity-span">
                                        <button type="submit">-</button>
                                        </span>
                                    </form>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <form action="{{ route('cart_items.update', $cartItem->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input class="quantity-input" type="text"  name="quantity" value="{{ $cartItem->quantity }}" style="max-width: 6rem">
                                    </form>
                                </td>
                                <td class="py-2 px-4 border-b" >
                                    <form action="{{ route('cart_items.quantity_plus', $cartItem->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <span class="quantity-span">
                                        <button type="submit">+</button>
                                        </span>
                                    </form>
                                </td>
                                <td class="py-2 px-4 border-b subtotal" align="left">
                                    ${{ number_format($cartItem->quantity * $cartItem->product->price, 0) }}
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <form id="deleteForm{{ $cartItem->id }}" action="{{ route('cart_items.destroy', $cartItem->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ $cartItem->product->name }}', {{ $cartItem->id }})">刪除</button>
                                    </form>
                                </td>
                            </tr>
                            @php
                                $totalAmountBySeller += $cartItem->quantity * $cartItem->product->price;
                            @endphp
                        @endforeach
                        </tbody>
                    </table>
                        @php
                            $totalAmount += $totalAmountBySeller;
                        @endphp
                        @endforeach

                        <hr>

                        <div class="text-left">
                            <strong>商品總運費：</strong>${{ number_format($totalShippingFee, 0) }}
                        </div>
                        <div class="text-left">
                            <strong>商品總金額：</strong>${{ number_format($totalAmount, 0) }}
                        </div>
                        <br>
                        <div class="text-left" style="height: 80px">
                            <strong>總金額(含運費)：</strong>${{ number_format($totalAmount + $totalShippingFee, 0) }}
                        </div>

                <form action="{{ route('orders.create') }}" method="GET" id="checkoutForm" onsubmit="return prepareCheckout(event)">
                    @csrf
                    @method('GET')
                    <input type="hidden" name="selected_items" id="selectedItemsInput" value="">
                    <div class="text-center">
                        <button class="btn btn-outline-dark mx-6 mt-auto" type="submit">結帳</button>
                    </div>
                </form>

            @else
                <p class="text-gray-600">購物車內無商品。</p>
            @endif
        </div>
    </div>


    <script>
        function confirmDelete(name, Id) {
            if (confirm("確定要刪除 " + name + " 嗎？")) {
                document.getElementById('deleteForm' + Id).submit();
            }
        }

        function prepareCheckout(event) {
            event.preventDefault();  // 防止表單直接提交

            const selectedItems = getSelectedItems();
            const checkoutForm = document.getElementById('checkoutForm');
            const selectedItemsInput = document.getElementById('selectedItemsInput');

            // 將選擇的商品ID添加到結帳表單的 input value 中
            selectedItemsInput.value = selectedItems.join(',');

            // 將選擇的商品ID添加到結帳表單的 query string 中
            const queryString = selectedItems.length > 0 ? `?selected_items=${selectedItems.join(',')}` : '';
            checkoutForm.action = "{{ route('orders.create') }}" + queryString;

            // 如果有選擇的商品，觸發表單提交
            if (selectedItems.length > 0) {
                checkoutForm.submit();
            } else {
                // 如果沒有選擇商品，取消表單提交
                alert("請勾選至少一個商品進行結帳。");
            }
        }


        function getSelectedItems() {
            const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
            const selectedItems = [];

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedItems.push(checkbox.value);
                }
            });

            return selectedItems;
        }

        function setOperationInput(operation) {
            const operationInput = document.getElementById('operationInput');
            operationInput.value = operation;
            document.getElementById('updateCartItemForm').submit();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateTotalAmount();
                });
            });

            function updateTotalAmount() {
                const subtotalElements = document.querySelectorAll('.subtotal');
                let totalAmount = 0;
                let totalShippingFee = parseFloat(document.getElementById('totalShippingFee').textContent.replace('$', ''));

                subtotalElements.forEach(subtotalElement => {
                    const checkbox = subtotalElement.closest('tr').querySelector('input[name="selected_items[]"]');
                    if (checkbox.checked) {
                        totalAmount += parseFloat(subtotalElement.textContent.replace('$', ''));
                    }
                });

                totalAmount += totalShippingFee;

                // Log for debugging
                console.log('Total Amount:', totalAmount);

                // 確保能正確獲取 totalAmount 元素
                const totalAmountElement = document.getElementById('totalAmount');

                if (totalAmountElement) {
                    totalAmountElement.textContent = `$${totalAmount.toFixed(0)}`;
                } else {
                    // Log for debugging
                    console.error('Total Amount Element not found!');
                }
            }
        });
    </script>
@endsection



