@extends('sellers.layouts.master')

@section('page-title', 'Edit article')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">訂單評價管理</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">新增評價</li>
        </ol>
        @include('sellers.layouts.shared.errors')
        <div class="form-group">
            <label for="name" class="form-label">買家</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name',$orderdetail->order->user->name) }}" readonly>
        </div>
        <div class="form-group">
            <label for="phone" class="form-label">收件人電話</label>
            <input id="receiver_phone" name="receiver_phone" type="text" class="form-control" value="{{ old('receiver_phone',$orderdetail->order->receiver_phone) }}" readonly>
        </div>
        <div class="form-group">
            <label for="receiver_address" class="form-label">收件人地址</label>
            <input id="receiver_address" name="receiver_address" type="text" class="form-control" value="{{ old('receiver_address',$orderdetail->order->receiver_address) }}" placeholder="請輸入內容" readonly>
        </div>
        <div class="form-group">
            <label for="price" class="form-label">訂單金額</label>
            <input id="price" name="price" type="text" class="form-control" value="{{ old('price',$orderdetail->order->price) }}" placeholder="請輸入價格" readonly>
        </div>
        <div class="form-group">
            <label for="seller_message" class="form-label">賣家留言內容</label>
            <textarea id="seller_message" name="seller_message" class="form-control" rows="10" placeholder="請輸入文章內容">{{ old('seller_message',$orderdetail->seller_message) }}</textarea>
        </div>

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
