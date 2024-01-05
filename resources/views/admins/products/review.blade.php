@extends('admins.layouts.master')

@section('page-title', 'Edit article')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">商品管理</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">編輯商品資料</li>
        </ol>
        @include('admins.layouts.shared.errors')
            <div class="form-group">
                <label for="name" class="form-label">商品名稱</label>
                <input id="name" name="name" type="text" class="form-control" value="{{ old('name',$product->name) }}" placeholder="請輸入書籍名稱" readonly>
            </div>
            <div class="form-group">
                <label for="image_url" class="form-label">商品圖片</label>
                <img id="image-preview" src="{{ $product->image_url ? asset('storage/products/' . $product->image_url) : '#' }}" alt="圖片預覽" style="width:200px; height:200px; display: {{ $product->image_url ? 'block' : 'none' }}" >
            </div>
            <div class="form-group">
                <label for="content" class="form-label">商品內容</label>
                <input id="content" name="content" type="text" class="form-control" value="{{ old('content',$product->content) }}" placeholder="請輸入內容" readonly>
            </div>
            <div class="form-group">
                <label for="price" class="form-label">價格</label>
                <input id="price" name="price" type="text" class="form-control" value="{{ old('price',$product->price) }}" placeholder="請輸入價格" readonly>
            </div>
            <div class="form-group">
                <label for="inventory" class="form-label">庫存</label>
                <input id="inventory" name="inventory" type="text" class="form-control" value="{{ old('inventory',$product->inventory) }}" placeholder="請輸入數量" readonly>
            </div>

            <form action="{{ route('admins.products.pass',$product->id) }}" method="POST" role="form">
                @method('PATCH')
                @csrf
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary btn-sm">通過申請</button>
                </div>
            </form>
            <form action="{{ route('admins.products.unpass',$product->id) }}" method="POST" role="form">
                @method('PATCH')
                @csrf
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary btn-sm">不通過申請</button>
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
@endsection
