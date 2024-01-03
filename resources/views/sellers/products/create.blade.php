@extends('sellers.layouts.master')

@section('page-title', 'Create article')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">商品管理</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">新增商品</li>
        </ol>
        @include('sellers.layouts.shared.errors')
        <form action="{{ route('sellers.products.store') }}" method="POST" role="form" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="form-group">
                <label for="product_category" class="form-label">選擇商品類別</label>
                <select id="product_category" name="product_category" class="form-control">
                    @foreach($product_category as $product_category)
                        <option value="{{ $product_category->id }}">{{ $product_category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="name" class="form-label">商品名稱</label>
                <input id="name" name="name" type="text" class="form-control" value="{{ old('name') }}" placeholder="請輸入商品名稱">
            </div>
            <div class="form-group">
                <label for="image_url" class="form-label">商品圖片</label>
                <input id="image_url" name="image_url" type="file" class="form-control" value="{{ old('image_url') }}" placeholder="請選擇商品圖片" onchange="previewImage(this);">
                <img id="image-preview" src="#" alt="圖片預覽" style="display: none; width:200px; height:200px;" >
            </div>
            <div class="form-group">
                <label for="detail" class="form-label">商品內容</label>
                <input id="detail" name="detail" type="text" class="form-control" value="{{ old('detail') }}" placeholder="請輸入商品內容">
            </div>
            <div class="form-group">
                <label for="price" class="form-label">價格</label>
                <input id="price" name="price" type="text" class="form-control" value="{{ old('price') }}" placeholder="請輸入商品價格">
            </div>
            <div class="form-group">
                <label for="inventory" class="form-label">數量</label>
                <input id="inventory" name="inventory" type="text" class="form-control" value="{{ old('inventory') }}" placeholder="請輸入商品數量">
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
@endsection
