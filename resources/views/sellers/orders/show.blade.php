@extends('sellers.layouts.master')

@section('page-title', 'Article list')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">訂單金流管理</h1>
        <table class="table">
            <thead>
            <tr>
                <th scope="col" style="text-align:left">#</th>
                <th scope="col" style="text-align:left">訂單編號</th>
                <th scope="col" style="text-align:left">進帳金額(已扣除抽成)</th>
                <th scope="col" style="text-align:left">建立日期</th>
{{--                <th scope="col" style="text-align:center">刪除</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->price * 0.95 }}</td>
                    <td>{{ $order->date }}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
