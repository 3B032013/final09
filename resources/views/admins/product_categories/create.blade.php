@extends('admins.layouts.master')

@section('page-title', 'Create article')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">書籍類別管理</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">新增書籍類別</li>
        </ol>
        @include('admins.layouts.shared.errors')
        <form action="{{ route('admins.product_categories.store') }}" method="POST" role="form">
            @method('POST')
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">書籍類別名稱</label>
                <input id="name" name="name" type="text" class="form-control" value="{{ old('name') }}" placeholder="請輸入商品名稱">
            </div>
            <input type="hidden" name="status" value=1>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary btn-sm">儲存</button>
            </div>
        </form>
    </div>
@endsection
