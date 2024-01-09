@extends('sellers.layouts.master')

@section('page-title', '評價管理')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">評價管理</h1>
        <table class="table">
            <thead>
            <tr>
                <th scope="col" style="text-align:left">#</th>
                <th scope="col" style="text-align:left">買家</th>
                <th scope="col" style="text-align:left">建立日期</th>
                <th scope="col" style="text-align:center">操作</th>
{{--                <th scope="col" style="text-align:center">刪除</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->user_id }}</td>
                    <td>{{ $order->date }}</td>
                    <td style="text-align:center">
                        <a href="{{ route('sellers.comments.edit',$order->id) }}" class="btn btn-secondary btn-sm">檢視評價</a>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
