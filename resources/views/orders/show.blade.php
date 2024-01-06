@extends('products.index.layouts.master')

@section('title', '訂單明細')

@section('content')
    <div class="wrapper">
        <div class="container mt-8">
            <h3 class="text-2xl mb-4" align="center">訂單明細</h3>
        </div>
    </div>
    <table class="min-w-full bg-white border border-gray-200 mx-auto" border="1">
        <tbody>
        <tr align="center">
            <th class="py-2">商品圖片</th>
            <th>商品名稱</th>
            <th>價格</th>
            <th>數量</th>
            <th>小計</th>
        </tr>
        @foreach ($order_details as $order_detail)
            <tr>
                <td class="py-2 px-4 border-b">
                    <img src="{{ asset('storage/products/' . $order_detail->product->image_url) }}" alt="{{ $order_detail->product->name }}" width="80px" height="80px">
                </td>
                <td class="py-2 px-4 border-b">{{ $order_detail->product->name }}</td>
                <td class="py-2 px-4 border-b price" data-price="{{ $order_detail->product->price }}">
                    ${{ $order_detail->product->price }}
                </td>
                <td class="py-2 px-4 border-b">
                    <span class="quantity-span">
                        {{ $order_detail->quantity }}
                    </span>
                </td>
                <td class="py-2 px-4 border-b subtotal">
                    ${{ number_format($order_detail->quantity * $order_detail->product->price, 0) }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="5" ><div class="text-center"><hr></div></td>
        </tr>
        <tr>
            <td>
                <div class="text-center">
                    訂單運費
                </div>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                <div class="text-center" style="color: red">
                    $60
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="text-center">
                    訂單金額
                </div>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                <div class="text-center" style="color: red">
                    ${{ $order_detail->order->price }}
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="5" ><div class="text-center"><hr></div></td>
        </tr>
        <tr>
            <td>
                <div class="text-center">
                    <strong>收件人資訊</strong>
                </div>
            </td>
            <td colspan="3"></td>
        </tr>

        <tr>
            <td>
                <div class="text-center" >
                    收件人名稱
                </div>
            </td>
            <td colspan="4">{{ $order_detail->order->receiver }}</td>
        </tr>
        <tr>
            <td>
                <div class="text-center" >
                    收件人電話
                </div>
            </td>
            <td colspan="4">{{ $order_detail->order->receiver_phone }}</td>
        </tr>
        <tr>
            <td>
                <div class="text-center" >
                    收件人地址
                </div>
            </td>
            <td colspan="4">{{ $order_detail->order->receiver_address }}</td>
        </tr>
        <tr>
            <td colspan="5" ><div class="text-center"><hr></div></td>
        </tr>
        <tr>
            <td>
                <div class="text-center" >
                    訂單建立日期
                </div>
            </td>
            <td colspan="4">{{ $order_detail->order->created_at }}</td>
        </tr>
        <tr>
            <td>
                <div class="text-center" >
                    訂單狀態資訊
                </div>
            </td>
            <td colspan="4">
                @if ($order_detail->order->status == '0')
                    <div style="color:#8d00ff; font-weight:bold;">
                        (未付款)
                    </div>
                @elseif ($order_detail->order->status == '1')
                    <div style="color:#FF0000; font-weight:bold;">
                        (待確認)
                    </div>
                @elseif ($order_detail->order->status == '2')
                    <div style="color:#ff6f00; font-weight:bold;">
                        (發貨中)
                    </div>
                @elseif ($order_detail->order->status == '3')
                    <div style="color:#ffea00; font-weight:bold;">
                        (已出貨)
                    </div>
                @elseif ($order_detail->order->status == '4')
                    <div style="color:#48ff00; font-weight:bold;">
                        (已送達)
                    </div>
                @elseif ($order_detail->order->status == '5')
                    <div style="color:#002aff; font-weight:bold;">
                        (已完成)
                    </div>
                @elseif ($order_detail->order->status == '7')
                    <div style="color:#ff00ea; font-weight:bold;">
                        (已取消訂單)
                    </div>
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="5" ><div class="text-center"><hr></div></td>
        </tr>
        @if($has_comment)
        <tr>
            <td>
                <div class="text-center">
                    <strong>訂單評論</strong>
                </div>
            </td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td>
                <div class="text-center" >
                    滿意度
                </div>
            </td>
            <td colspan="4">
                <br>
                <div class="rating d-flex justify-content-center mb-4">
                    @for ($i = 5; $i >= 1; $i--)
                        <input type="radio" id="star{{ $i }}" name="comment_rating" value="{{ $i }}" {{ old('buyer_rating', optional($order_detail->order->comment)->buyer_rating) == $i ? 'checked' : '' }} disabled>
                        <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                    @endfor
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="5">
            <textarea id="buyer_message" name="buyer_message" class="form-control" rows="10" readonly>
                {{ old('buyer_message', optional($order_detail->order->comment)->buyer_message) }}</textarea>
            </td>
        </tr>
        @endif
        <tr>
            <td colspan="3"></td>
            <td>
                @if ($order_detail->order->status == '0')
                    <form action="{{ route('orders.payment', $order_detail->order->id) }}" method="GET">
                        @csrf
                        @method('GET')
                        <div class="text-left">
                            <button class="btn btn-outline-dark mx-6 mt-auto" type="submit">付款</button><br><br>
                        </div>
                    </form>
                @endif
            </td>
            <td>
                @if ($order_detail->order->status == '4')
                    <form action="{{ route('orders.complete_order', $order_detail->order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="text-left">
                            <button class="btn btn-outline-dark mx-6 mt-auto" type="submit">完成訂單</button><br><br>
                        </div>
                    </form>
                @elseif($order_detail->order->status == '5')
                    @if($has_comment)
                    <form action="{{ route('comments.edit', $order_detail->order->id) }}" method="GET">
                        @csrf
                        @method('GET')
                        <div class="text-left">
                            <button class="btn btn-outline-dark mx-6 mt-auto" type="submit">修改評論</button><br><br>
                        </div>
                    </form>
                    @else
                        <form action="{{ route('comments.create', $order_detail->order->id) }}" method="GET">
                            @csrf
                            @method('GET')
                            <div class="text-left">
                                <button class="btn btn-outline-dark mx-6 mt-auto" type="submit">評論</button><br><br>
                            </div>
                        </form>
                    @endif
                @elseif($order_detail->order->status != '7' and $order_detail->order->status != '5')
                    <form id="cancelForm{{ $order_detail->order->id }}" action="{{ route('orders.cancel_order', $order_detail->order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="text-left">
                            <button class="btn btn-outline-dark mx-6 mt-auto" onclick="confirmCancel('{{ $order_detail->order->id }}')" type="button">取消訂單</button><br><br>
                        </div>
                    </form>
                @endif
            </td>
        </tr>
        </tbody>
    </table>
@endsection

<script>
    function confirmCancel(orderId) {
        if (confirm("確定要取消訂單嗎？")) {
            document.getElementById('cancelForm' + orderId).submit();
        }
    }
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
