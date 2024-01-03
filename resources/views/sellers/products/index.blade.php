@extends('sellers.layouts.master')

@section('page-title', 'Article list')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">商品管理</h1>
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
                <th scope="col" style="text-align:left">數量</th>
                <th scope="col" style="text-align:center">修改</th>
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
    </div>
@endsection
