@extends('admins.layouts.master')

@section('page-title', 'Edit article')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">訂單管理</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">檢視訂單資料</li>
        </ol>
{{--        @include('admins.layouts.shared.errors')--}}
        <div class="form-group">
            <label for="buyer" class="form-label">買家</label>
            <input id="buyer" name="buyer" type="text" class="form-control" value="{{ old('buyer',$order->user->name) }}" readonly>
        </div>
        <div class="form-group">
            <label for="seller" class="form-label">賣家</label>
            <input id="seller" name="seller" type="text" class="form-control" value="{{ old('seller',$order->seller->user->name) }}" readonly>
        </div>
        <div class="form-group">
            <label for="date" class="form-label">訂單日期</label>
            <input id="date" name="date" type="text" class="form-control" value="{{ old('date',$order->date) }}" readonly>
        </div>
        <div class="form-group">
            <label for="status" class="form-label">狀態</label>
            @if ($order->status == '1')
                <input id="status" name="status" type="text" class="form-control" value="待確認" readonly>
            @elseif ($order->status == '2')
                <input id="status" name="status" type="text" class="form-control" value="出貨中" readonly>
            @elseif ($order->status == '3')
                <input id="status" name="status" type="text" class="form-control" value="已出貨" readonly>
            @elseif ($order->status == '4')
                <input id="status" name="status" type="text" class="form-control" value="已送達" readonly>
            @elseif ($order->status == '5')
                <input id="status" name="status" type="text" class="form-control" value="已完成" readonly>
            @elseif ($order->status == '6')
                <input id="status" name="status" type="text" class="form-control" value="退貨" readonly>
            @elseif ($order->status == '7')
                <input id="status" name="status" type="text" class="form-control" value="取消" readonly>
            @elseif ($order->status == '8')
                <input id="status" name="status" type="text" class="form-control" value="未成立" readonly>
            @endif</td>
        </div>
        <br><h3>訂單明細</h3>
        @foreach ($order -> orderDetails as $index => $orderDetail)
        <div class="form-group">
            <label for="order_detail" class="form-label">書籍{{$index + 1}}</label>
            <input id="order_detail" name="order_detail" type="text" class="form-control" value="{{ old('order_detail',$orderDetail->product->name) }}" readonly>
        </div>
        @endforeach
        @if (!in_array($order->status, [5, 6, 7, 8]))
        <form action="{{ route('admins.orders.cancel',$order->id) }}" method="POST" role="form">
            @method('PATCH')
            @csrf
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary btn-sm">強制取消訂單</button>
            </div>
        </form>
        @else
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">目前狀態無法取消訂單</div>
        @endif
    </div>
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
@endsection
