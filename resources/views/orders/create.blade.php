@extends('products.index.layouts.master')

@section('title', '訂單')

@section('content')
    <hr>
    <div class="wrapper">
        <div class="container mt-8">
            <h3 class="text-2xl mb-4" align="center">訂單結帳</h3>
        </div>
    </div>

    @if ($selectedCartItems->count() > 0)
        <form id="checkoutForm" action="{{ route('orders.store') }}" method="POST">
            @csrf
            @method('POST')
            <table class="min-w-full bg-white border border-gray-200 mx-auto" border="1">
                <tr align="center">
                    <th class="py-2">商品圖片</th>
                    <th>商品名稱</th>
                    <th>價格</th>
                    <th>數量</th>
                    <th>小計</th>
                </tr>
                <tbody>
                @php
                    $currentSeller = null;
                    $totalSum = 0;
                @endphp
                @foreach ($selectedCartItems as $selectedCartItem)
                    @if ($currentSeller !== $selectedCartItem->product->seller->id)
                        <tr>
                            <td colspan="5">
                                <br>&nbsp賣家：{{ $selectedCartItem->product->seller->user->name }}
                            </td>
                        </tr>
                        @php
                            $currentSeller = $selectedCartItem->product->seller->id;
                        @endphp
                    @endif

                    <tr>
                        <td class="py-2 px-4 border-b">
                            <img src="{{ asset('storage/products/' . $selectedCartItem->product->image_url) }}" alt="{{ $selectedCartItem->product->name }}" width="80px" height="80px">
                        </td>
                        <td class="py-2 px-4 border-b">{{ $selectedCartItem->product->name }}</td>
                        <td class="py-2 px-4 border-b price" data-price="{{ $selectedCartItem->product->price }}">
                            ${{ $selectedCartItem->product->price }}
                        </td>
                        <td class="py-2 px-4 border-b">
                            <span class="quantity-span">
                                {{ $selectedCartItem->quantity }}
                            </span>
                        </td>
                        <td class="py-2 px-4 border-b subtotal">
                            ${{ number_format($selectedCartItem->quantity * $selectedCartItem->product->price, 0) }}
                        </td>
                    </tr>
                    @php
                        $totalSum += $selectedCartItem->quantity * $selectedCartItem->product->price;
                    @endphp
                @endforeach
                <tr>
                    <td colspan="5">
                        <br><h4>&nbsp會員資訊</h4>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <p>&nbsp&nbsp會員名稱： <span id="member-name">{{ $selectedCartItem->user->name }}</span></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <p>&nbsp&nbsp會員電話： <span id="member-phone">{{ $selectedCartItem->user->phone }}</span></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <p>&nbsp&nbsp會員地址： <span id="member-address">{{ $selectedCartItem->user->address }}</span></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <h4>&nbsp收件人資訊</h4>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        &nbsp&nbsp<input type="checkbox" id="same-as-member" onchange="copyMemberInfo()">&nbsp&nbsp同買家資訊<br>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div id="shipping-info">
                            <label for="receiver">&nbsp&nbsp收件人名稱:</label>
                            <input type="text" id="recipient-name" name="receiver" placeholder="收件人名稱" required><br><br>

                            <label for="receiver_phone">&nbsp&nbsp收件人電話:</label>
                            <input type="text" id="recipient-phone" name="receiver_phone" placeholder="收件人電話" required><br><br>

                            <label for="receiver_address">&nbsp&nbsp收件人名稱:</label>
                            <input type="text" id="recipient-address" name="receiver_address" placeholder="收件人名稱" required><br><br>
                        </div>
                    </td>
                </tr>
                <input type="hidden" name="selected_items" value="{{ json_encode($selectedCartItems) }}">
                <tr>
                    <td colspan="5">
                        <div class="text-center">
                            總金額：${{ number_format($totalSum, 0) }}
                            <button class="btn btn-outline-dark mx-6 mt-auto" type="submit">下單</button><br><br>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    @else
        <p class="text-gray-600">購物車內無商品。</p>
    @endif
    <script>
        function copyMemberInfo() {
            // 獲取會員的資訊
            const memberName = document.getElementById('member-name').innerText;
            const memberPhone = document.getElementById('member-phone').innerText;
            const memberAddress = document.getElementById('member-address').innerText;

            // 獲取收件人的 input 元素
            const recipientNameInput = document.getElementById('recipient-name');
            const recipientPhoneInput = document.getElementById('recipient-phone');
            const recipientAddressInput = document.getElementById('recipient-address');

            // 獲取同買家資訊的 checkbox
            const sameAsMemberCheckbox = document.getElementById('same-as-member');

            if (sameAsMemberCheckbox.checked) {
                // 將會員的資訊填入收件人的 input 元素
                recipientNameInput.value = memberName;
                recipientPhoneInput.value = memberPhone;
                recipientAddressInput.value = memberAddress;

                // 設定 input 元素為 readonly
                recipientNameInput.readOnly = true;
                recipientPhoneInput.readOnly = true;
                recipientAddressInput.readOnly = true;
            } else {
                // 清空收件人的 input 元素
                recipientNameInput.value = '';
                recipientPhoneInput.value = '';
                recipientAddressInput.value = '';

                // 移除 input 元素的 readonly 屬性
                recipientNameInput.readOnly = false;
                recipientPhoneInput.readOnly = false;
                recipientAddressInput.readOnly = false;
            }
        }
    </script>
    <style>
        /* 設定單獨 input 欄位的 readonly 時的背景色 */
        #recipient-name[readonly], #recipient-phone[readonly], #recipient-address[readonly] {
            background-color: #f4f4f4; /* 你想要的灰色背景色 */
        }
    </style>
@endsection
