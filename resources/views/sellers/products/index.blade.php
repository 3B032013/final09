@extends('sellers.layouts.master')

@section('page-title', 'Article list')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">商品管理</h1>
        <div class="container px-4 px-lg-5 mt-2 mb-4">
            <form action="{{ route('sellers.products.search') }}" method="GET" class="d-flex">
                <input type="text" name="query" class="form-control me-2" placeholder="關鍵字搜尋...">
                <button type="submit" class="btn btn-outline-dark">搜尋</button>
            </form>
        </div>
        @if (request()->has('query'))
            <div class="container px-4 px-lg-5 mt-2 mb-4">
                查找「{{ request('query') }}」
                <a class="btn btn-success btn-sm" href="{{ route('sellers.products.index') }}">取消搜尋</a>
            </div>
        @endif
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('sellers.products.create') }}">新增商品</a>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col" style="text-align:left">商品名稱</th>
                <th scope="col" style="text-align:left">商品圖片</th>
                <th scope="col" style="text-align:left">商品簡述</th>
                <th scope="col" style="text-align:left">價格</th>
                <th scope="col" style="text-align:left">庫存</th>
                <th scope="col" style="text-align:center">修改</th>
                <th scope="col" style="text-align:center">狀態</th>
                <th scope="col" style="text-align:center">操作</th>
                <th scope="col" style="text-align:center">刪除</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td><img src="{{ asset( 'storage/products/' . $product->image_url) }}" alt="{{ $product->name }}" height="100px" width="100px"></td>
                    <td>{{ $product->detail }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->inventory }}</td>
                    <td style="text-align:center">
                        <a href="{{ route('sellers.products.edit',$product->id) }}" class="btn btn-secondary btn-sm">編輯</a>
                    </td>
                    <td>
                        @if ($product->status == 0)
                            <div style="color:#FF0000; font-weight:bold;">
                                (申請中)
                            </div>
                        @elseif ($product->status == 1)
                            <div style="color:#FF8033; font-weight:bold;">
                                (申請通過)
                            </div>
                        @elseif ($product->status == 2)
                            <div style="color:#33FF33; font-weight:bold;">
                                (申請失敗)
                            </div>
                        @elseif ($product->status == 3)
                            <div style="color:#FFB233; font-weight:bold;">
                                (上架)
                            </div>
                        @elseif ($product->status == 4)
                            <div style="color:#FFB233; font-weight:bold;">
                                (下架)
                            </div>

                        @endif
                    </td>
                    <td style="text-align:center">
                        @if ($product->status == 0)

                        @elseif ($product->status == 1)
                            <form action="{{ route('sellers.products.statuson',$product->id) }}" method="POST" role="form">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">上架</button>
                            </form>
                        @elseif ($product->status == 2)
                            <form action="{{ route('sellers.products.reply',$product->id) }}" method="POST" role="form">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">重新申請</button>
                            </form>
                        @elseif ($product->status == 3)
                            <form action="{{ route('sellers.products.statusoff',$product->id) }}" method="POST" role="form">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">下架</button>
                            </form>
                        @elseif ($product->status == 4)
                            <form action="{{ route('sellers.products.statuson',$product->id) }}" method="POST" role="form">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">上架</button>
                            </form>
                        @endif
                    </td>

                    <td style="text-align:center">
                        <form action="{{ route('sellers.products.destroy',$product->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">刪除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="d-flex align-items-center">
                <span class="mr-1">每</span>
                <select id="records-per-page" class="form-control" onchange="changeRecordsPerPage()">
                    <option value="5" {{ $products->perPage() == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $products->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $products->perPage() == 20 ? 'selected' : '' }}>20</option>
                </select>
                <span class="ml-1">筆</span>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            @if ($products->currentPage() > 1)
                <a href="{{ $products->previousPageUrl() }}" class="btn btn-secondary">上一頁</a>
            @endif

            <span class="mx-2">全部 {{ $products->total() }} 筆資料，目前位於第 {{ $products->currentPage() }} 頁，共 {{ $products->lastPage() }} 頁</span>

            @if ($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" class="btn btn-secondary">下一頁</a>
            @endif
        </div>
    </div>
    <script>
        function changeRecordsPerPage() {
            const select = document.getElementById('records-per-page');
            const value = select.options[select.selectedIndex].value;
            window.location.href = `{{ route('sellers.products.index') }}?perPage=${value}`;
        }
    </script>
@endsection
