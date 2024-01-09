@extends('products.index.layouts.master')

@section('title', '訂單結帳')

@section('page-path')
    <div>
        <p style="font-size: 1.2em;"><a href="{{ route('home') }}">
                <i class="fa fa-home"></i></a> &gt;
              結帳
        </p>
    </div>
@endsection

@section('content')
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            {{ $errors->first('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="wrapper">
        <div class="container mt-8">
            <h3 class="text-2xl mb-4" align="center">訂單結帳</h3>
        </div>
    </div>

    @if ($selectedCartItems->count() > 0)
        <form id="checkoutForm" action="{{ route('orders.show_store',['product' => $selectedCartItems->id]) }}" method="POST">
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
                    $totalSum = 0;
                @endphp
                    <tr>
                        <td colspan="5">
                            <br>&nbsp賣家：{{ $selectedCartItems->seller->user->name }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border-b">
                            <img src="{{ asset('storage/products/' . $selectedCartItems->image_url) }}" alt="{{ $selectedCartItems->name }}" width="80px" height="80px">
                        </td>
                        <td class="py-2 px-4 border-b">{{ $selectedCartItems->name }}</td>
                        <td class="py-2 px-4 border-b price" data-price="{{ $selectedCartItems->price }}">
                            ${{ $selectedCartItems->price }}
                        </td>
                        <td class="py-2 px-4 border-b">
                            <span class="quantity-span">
                                1
                            </span>
                        </td>
                        <td class="py-2 px-4 border-b subtotal">
                            ${{ $selectedCartItems->price }}
                        </td>
                    </tr>
                <tr>
                    <td colspan="5" ><div class="text-center"><hr></div></td>
                </tr>
                <tr>
                    <td colspan="5" >
                        <p>&nbsp&nbsp商品總運費：$ <span>60</span></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <p>&nbsp&nbsp商品總金額：$<span>{{ $selectedCartItems->price }}</span></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" ><div class="text-center"><hr></div></td>
                </tr>
                <tr>
                    <td colspan="5">
                        <br><h4>&nbsp會員資訊</h4>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <p>&nbsp&nbsp會員名稱： <span id="member-name">{{ Auth()->user()->name }}</span></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <p>&nbsp&nbsp會員電話： <span id="member-phone">{{ Auth()->user()->phone }}</span></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <p>&nbsp&nbsp會員地址： <span id="member-address">{{ Auth()->user()->address }}</span></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" ><div class="text-center"><hr></div></td>
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

                            <label for="receiver_address">&nbsp&nbsp收件人地址:</label>
                            <input type="text" id="recipient-address" name="receiver_address" placeholder="收件人名稱" required><br><br>
                        </div>
                    </td>
                </tr>
{{--                <input type="hidden" name=item_id" value="{{ $selectedCartItems->id }}">--}}
                <tr>
                    <td colspan="5">
                        <div class="text-center">
                            總金額(含運費)：<font color="red">${{ $selectedCartItems->price+60 }}</font>
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
