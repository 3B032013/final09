@extends('products.index.layouts.master')

@section('title', '訂單')

@section('content')
    <hr>
    <div class="wrapper">
        <div class="container mt-8">
            <h3 class="text-2xl mb-4" align="center">訂購清單</h3>
            {{--            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp--}}
            {{--            <a href="#" style="text-decoration: none;color: black" >歷史訂單</a>--}}
        </div>
    </div>
    <table border="0" align="center">
        <thead align="center">
        <tbody>
        <tr style="height: 100px">
            <th>
                <div class="container mt-4 text-center">
                    <form action="{{ route('orders.index') }}" method="GET">
                        @method('GET')
                        <button type="submit" class="btn btn-secondary mx-2">所有訂單</button>
                    </form>
                </div>
            </th>
            <th>
                <div class="container mt-4 text-center">
                    <form action="{{ route('orders.filter') }}" method="GET">
                        @method('GET')
                        <input type="text" name="status" value="0" hidden>
                        <button type="submit" class="btn btn-secondary mx-2">未付款</button>
                    </form>
                </div>
            </th>
            <th>
                <div class="container mt-4 text-center">
                    <form action="{{ route('orders.filter') }}" method="GET">
                        @method('GET')
                        <input type="text" name="status" value="1" hidden>
                        <button type="submit" class="btn btn-secondary mx-2">待出貨</button>
                    </form>
                </div>
            </th>
            <th>
                <div class="container mt-4 text-center">
                    <form action="{{ route('orders.filter') }}" method="GET">
                        @method('GET')
                        <input type="text" name="status" value="4" hidden>
                        <button type="submit" class="btn btn-secondary mx-2">待收貨</button>
                    </form>
                </div>
            </th>
            <th>
                <div class="container mt-4 text-center">
                    <form action="{{ route('orders.filter') }}" method="GET">
                        @method('GET')
                        <input type="text" name="status" value="5" hidden>
                        <button type="submit" class="btn btn-secondary mx-2">已完成</button>
                    </form>
                </div>
            </th>
            <th>
                <div class="container mt-4 text-center">
                    <form action="{{ route('orders.filter') }}" method="GET">
                        @method('GET')
                        <input type="text" name="status" value="7" hidden>
                        <button type="submit" class="btn btn-secondary mx-2">未成立</button>
                    </form>
                </div>
            </th>
        </tr>

        </tbody></thead>
    </table>
    @if(count($orders) > 0)
        <table class="min-w-full bg-white border border-gray-200 mx-auto" border="1">
            <thead align="center">
            <tr  align="center">
                <th width="200" height="30">訂單</th>
                <th width="200" height="30">建立日期</th>
                <th width="200" height="30">狀態</th>
                <th width="200" height="30">訂單內容</th>
            </tr>
            </thead>
        </table>
        <table class="min-w-full bg-white border border-gray-200 mx-auto" border="1">
            <tbody>
            @foreach ($orders as $order)
                <tr  align="center">
                    <td width="200" height="50">訂單{{ $order->id }}</td>
                    <td width="200" height="50">{{ $order->created_at }}</td>
                    <td width="200" height="50">
                        @if ($order->status == '0')
                            <div style="color:#8d00ff; font-weight:bold;">
                                (未付款)
                            </div>
                        @elseif ($order->status == '1')
                            <div style="color:#FF0000; font-weight:bold;">
                                (待確認)
                            </div>
                        @elseif ($order->status == '2')
                            <div style="color:#ff6f00; font-weight:bold;">
                                (發貨中)
                            </div>
                        @elseif ($order->status == '3')
                            <div style="color:#ffea00; font-weight:bold;">
                                (已出貨)
                            </div>
                        @elseif ($order->status == '4')
                            <div style="color:#48ff00; font-weight:bold;">
                                (已送達)
                            </div>
                        @elseif ($order->status == '5')
                            <div style="color:#002aff; font-weight:bold;">
                                (已完成)
                            </div>
                        @elseif ($order->status == '7')
                            <div style="color:#ff00ea; font-weight:bold;">
                                (已取消)
                            </div>
                        @endif
                    </td>
                    <td width="200" height="50">
                        <a href="{{ route('orders.show',$order->id) }}" style="text-decoration: none;color: black" ><strong>查看訂單</strong></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <br><br><div align="center"><h3>目前無訂單</h3></div>
    @endif
@endsection



