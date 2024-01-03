@extends('products.index.layouts.master')

@section('title', '訂單')

@section('content')
    <hr>
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
        @php
            $totalSum = 0;
        @endphp
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
                    <form action="#" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="text-left">
                            <button class="btn btn-outline-dark mx-6 mt-auto" type="submit">完成訂單</button><br><br>
                        </div>
                    </form>
                @elseif($order_detail->order->status == '5')
                    <form action="#" method="GET">
                        @csrf
                        @method('GET')
                        <div class="text-left">
                            <button class="btn btn-outline-dark mx-6 mt-auto" type="submit">評論</button><br><br>
                        </div>
                    </form>
                @elseif($order_detail->order->status != '7' and $order_detail->order->status != '5')
                    <form action="#" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="text-left">
                            <button class="btn btn-outline-dark mx-6 mt-auto" type="submit">取消訂單</button><br><br>
                        </div>
                    </form>
                @endif
            </td>
        </tr>
        </tbody>
    </table>
@endsection

