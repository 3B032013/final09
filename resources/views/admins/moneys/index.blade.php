@extends('admins.layouts.master')

@section('page-title', '金流管理')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">金流管理</h1>
        <table class="table">
            <thead>
            <tr>
                <th scope="col" style="text-align:left">#</th>
                <th scope="col" style="text-align:left">買家</th>
                <th scope="col" style="text-align:left">賣家</th>
                <th scope="col" style="text-align:left">訂單日期</th>
                <th scope="col" style="text-align:right">金額</th> <!-- New column for amount -->
                <th scope="col" style="text-align:center">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->seller->user->name }}</td>
                    <td>{{ $order->date }}</td>
                    <td style="text-align:right">{{ $order->calculateTotalProfit() }}</td>
                    <td style="text-align:center">
                        <a href="{{ route('admins.orders.show',$order->id) }}" class="btn btn-secondary btn-sm">檢視</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <!-- Display the total profit -->
        <div class="d-flex justify-content-end mt-4">
            <strong>總收益： {{ $totalProfit }}元</strong>
        </div>
    </div>
@endsection
