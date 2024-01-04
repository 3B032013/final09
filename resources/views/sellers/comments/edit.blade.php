@extends('sellers.layouts.master')

@section('page-title', 'Edit article')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">訂單評價管理</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">編輯評價</li>
        </ol>
        @include('sellers.layouts.shared.errors')
        <form action="{{ route('sellers.comments.update',$order->id) }}" method="POST" role="form" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
         <input type="hidden" name="order_id" value="{{ $order->id }}">
            <div class="form-group">
                <label for="name" class="form-label">買家名稱</label>
                <input id="name" name="name" type="text" class="form-control" value="{{ old('name',$order->user->name) }}" readonly>
            </div>
            <div class="form-group">
                <label for="phone" class="form-label">收件人電話</label>
                <input id="receiver_phone" name="receiver_phone" type="text" class="form-control" value="{{ old('receiver_phone',$order->receiver_phone) }}" readonly>
            </div>
            <div class="form-group">
                <label for="receiver_address" class="form-label">收件人地址</label>
                <input id="receiver_address" name="receiver_address" type="text" class="form-control" value="{{ old('receiver_address',$order->receiver_address) }}" placeholder="請輸入內容" readonly>
            </div>
            <div class="form-group">
                <label for="price" class="form-label">訂單金額</label>
                <input id="price" name="price" type="text" class="form-control" value="{{ old('price',$order->price) }}" placeholder="請輸入價格" readonly>
            </div>
            <div class="form-group">
                <label for="seller_message" class="form-label">賣家留言內容</label>
                <textarea id="seller_message" name="seller_message" class="form-control" rows="10" placeholder="請輸入文章內容">{{ old('seller_message', optional($order->comment)->seller_message) }}</textarea>
            </div>
            <div class="form-group">
                <label for="seller_rating" class="form-label">星星評分</label>
                <div class="rating">
                    @for ($i = 5; $i >= 1; $i--)
                        <input type="radio" id="star{{ $i }}" name="seller_rating" value="{{ $i }}" {{ old('seller_rating', optional($order->comment)->seller_rating) == $i ? 'checked' : '' }}>
                        <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                    @endfor
                </div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary btn-sm">儲存</button>
            </div>
        </form>
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
