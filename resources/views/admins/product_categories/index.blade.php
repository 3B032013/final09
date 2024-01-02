@extends('admins.layouts.master')

@section('page-title', '商品類別管理')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">書籍類別管理</h1>
        <div class="container px-4 px-lg-5 mt-2 mb-4">
            <form action="{{ route('admins.product_categories.search') }}" method="GET" class="d-flex">
                <input type="text" name="query" class="form-control me-2" placeholder="關鍵字搜尋...">
                <button type="submit" class="btn btn-outline-dark">搜尋</button>
            </form>
        </div>
        @if (request()->has('query'))
            <div class="container px-4 px-lg-5 mt-2 mb-4">
                查找「{{ request('query') }}」
                <a class="btn btn-success btn-sm" href="{{ route('admins.product_categories.index') }}">取消搜尋</a>
            </div>
        @endif
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('admins.product_categories.create') }}">新增書籍類別</a>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col" style="text-align:left">書籍類別名稱</th>
                <th scope="col" style="text-align:left">狀態</th>
                <th scope="col" style="text-align:center">修改狀態</th>
                <th scope="col" style="text-align:center">修改</th>
                <th scope="col" style="text-align:center">刪除</th>
            </tr>
            </thead>
            <tbody>
            @foreach($product_categories as $product_category)
                <tr>
                    <td>{{ $product_category->name }}</td>
                    <td>
                        @if ($product_category->status == 1)
                            <div style="color:#33FF33; font-weight:bold;">
                            (啟用中)
                            </div>
                        @else
                            <div style="color:#FF0000; font-weight:bold;">
                            (未啟用)
                            </div>
                        @endif
                    </td>
                    <td style="text-align:center">
                    @if ($product_category->status == 1)
                    <form action="{{ route('admins.product_categories.statusOff',$product_category->id) }}" method="POST" role="form">
                        @method('PATCH')
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm">停用</button>
                    </form>
                    @else
                    <form action="{{ route('admins.product_categories.statusOn',$product_category->id) }}" method="POST" role="form">
                        @method('PATCH')
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm">啟用</button>
                    </form>
                    @endif
                    </td>

                    <td style="text-align:center">
                        <a href="{{ route('admins.product_categories.edit',$product_category->id) }}" class="btn btn-secondary btn-sm">編輯</a>
                    </td>
                    <td style="text-align:center">
{{--                        <form action="{{ route('admins.product_categories.destroy',$product_category->id) }}" method="POST">--}}
{{--                            @method('DELETE')--}}
{{--                            @csrf--}}
{{--                            <button type="submit" class="btn btn-danger btn-sm">刪除</button>--}}
{{--                        </form>--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="d-flex align-items-center">
                <span class="mr-1">每</span>
                <select id="records-per-page" class="form-control" onchange="changeRecordsPerPage()">
                    <option value="5" {{ $product_categories->perPage() == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $product_categories->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $product_categories->perPage() == 20 ? 'selected' : '' }}>20</option>
                </select>
                <span class="ml-1">筆</span>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            @if ($product_categories->currentPage() > 1)
                <a href="{{ $product_categories->previousPageUrl() }}" class="btn btn-secondary">上一頁</a>
            @endif

            <span class="mx-2">全部 {{ $product_categories->total() }} 筆資料，目前位於第 {{ $product_categories->currentPage() }} 頁，共 {{ $product_categories->lastPage() }} 頁</span>

            @if ($product_categories->hasMorePages())
                <a href="{{ $product_categories->nextPageUrl() }}" class="btn btn-secondary">下一頁</a>
            @endif
        </div>
    </div>
@endsection
