@extends('admins.layouts.master')

@section('page-title', 'Edit article')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">書籍類別管理</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">編輯書籍類別</li>
        </ol>
        @include('admins.layouts.shared.errors')
        <form action="{{ route('admins.product_categories.update',$product_category->id) }}" method="POST" role="form" >
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">書籍類別名稱	</label>
                <input id="name" name="name" type="text" class="form-control" value="{{ old('name',$product_category->name) }}" placeholder="請輸入帳號">
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
