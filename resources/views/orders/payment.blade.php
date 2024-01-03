@extends('products.index.layouts.master')

@section('title', '訂單')

@section('content')
    <hr>
    <div class="wrapper">
        <div class="container mt-8">
            <h3 class="text-2xl mb-4" align="center">付款明細</h3>
        </div>
    </div>
    <table class="min-w-full bg-white border border-gray-200 mx-auto" border="1">
        <tbody>
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
            @php
                $totalSum += $order_detail->quantity * $order_detail->product->price;
            @endphp
        @endforeach
        <tr>
            <td colspan="5" ><div class="text-center"><hr></div></td>
        </tr>
        <tr>
            <td colspan="5">
                <div class='form-row row'>
                    <div class='col-xs-12 form-group required'>
                        <label class='control-label'>卡片號碼：</label>
                        <input class='form-control' size='4' type='text' required>
                    </div>

                    <div class='col-xs-12 col-md-4 form-group cvc required'>
                        <label class='control-label'>CVC</label>
                        <input autocomplete='off' class='form-control card-cvc' placeholder='e.g 415' size='4' type='text' required>
                    </div>

                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                        <label class='control-label'>到期月份</label>
                        <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text' required>
                    </div>

                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                        <label class='control-label'>到期年份</label>
                        <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text' required>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="5" ><div class="text-center"><hr></div></td>
        </tr>
        <tr>
            <td colspan="5" align="right">
                <form action="#" method="POST" role="form">
                    @method('PATCH')
                    @csrf
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary btn-sm">立即付款 (${{ number_format($totalSum, 0) }})</button><br><br>
                    </div><br>
                </form>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
