@extends('products.index.layouts.master')

@section('title', '訂購清單')

@section('page-path')
    <div>
        <p style="font-size: 1.2em;"><a href="{{ route('home') }}">
                <i class="fa fa-home"></i></a> &gt;
            訂購清單
        </p>
    </div>
@endsection

@section('content')
    <div class="wrapper">
        <div class="container mt-8">
            <h3 class="text-2xl mb-4" align="center">訂購清單</h3>
        </div>
    </div>
    <div class="container px-4 px-lg-5 mt-2 mb-4">
        <form action="{{ route('orders.search') }}" method="GET" class="d-flex">
            <input type="text" name="query" class="form-control me-2" placeholder="關鍵字搜尋...">
            <button type="submit" class="btn btn-outline-dark">搜尋</button>
        </form>
    </div>
    @if (request()->has('query'))
        <div class="container px-4 px-lg-5 mt-2 mb-4">
            查找「{{ request('query') }}」
            <a class="btn btn-success btn-sm" href="{{ route('orders.index') }}">取消搜尋</a>
        </div>
    @endif
    <table class="mx-auto" border="0">
        <thead align="center">
        <tr  align="center">
            <th width="200" height="30"><form action="{{ route('orders.index') }}" method="GET">
                    @method('GET')
                    <button type="submit" class="button">所有訂單</button>
                </form></th>
            <th width="200" height="30"><form action="{{ route('orders.filter') }}" method="GET">
                    @method('GET')
                    <input type="text" name="status" value="0" hidden>
                    <button type="submit" class="button">未付款</button>
                </form></th>
            <th width="200" height="30"><form action="{{ route('orders.filter') }}" method="GET">
                    @method('GET')
                    <input type="text" name="status" value="1" hidden>
                    <input type="text" name="status2" value="2" hidden>
                    <input type="text" name="status3" value="3" hidden>
                    <input type="text" name="status4" value="4" hidden>
                    <button type="submit" class="button">處理中</button>
                </form></th>
            <th width="200" height="30"><form action="{{ route('orders.filter') }}" method="GET">
                    @method('GET')
                    <input type="text" name="status" value="5" hidden>
                    <button type="submit" class="button">已完成</button>
                </form></th>
            <th width="200" height="30"><form action="{{ route('orders.filter') }}" method="GET">
                    @method('GET')
                    <input type="text" name="status" value="7" hidden>
                    <button type="submit" class="button">未成立</button>
                </form></th>
        </tr>
        </thead>
    </table>
    @if(count($orders) > 0)
        <table class="min-w-full bg-white border border-gray-200 mx-auto" border="1">
            <thead align="center">
            <tr  align="center">
                <th width="200" height="30">#</th>
                <th width="200" height="30">賣家</th>
                <th width="200" height="30">建立日期</th>
                <th width="200" height="30">商品數</th>
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
                    <td width="200" height="50">{{ $order->seller->user->name }}</td>
                    <td width="200" height="50">{{ $order->created_at }}</td>
                    <td width="200" height="50">{{ count($order->orderitems)}}</td>
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
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="d-flex align-items-center">
                <span class="mr-1">每</span>
                <select id="records-per-page" class="form-control" onchange="changeRecordsPerPage()">
                    <option value="5" {{ $orders->perPage() == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $orders->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $orders->perPage() == 20 ? 'selected' : '' }}>20</option>
                </select>
                <span class="ml-1">筆</span>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            @if ($orders->currentPage() > 1)
                <a href="{{ $orders->previousPageUrl() }}" class="btn btn-secondary">上一頁</a>
            @endif

            <span class="mx-2">全部 {{ $orders->total() }} 筆資料，目前位於第 {{ $orders->currentPage() }} 頁，共 {{ $orders->lastPage() }} 頁</span>

            @if ($orders->hasMorePages())
                <a href="{{ $orders->nextPageUrl() }}" class="btn btn-secondary">下一頁</a>
            @endif
        </div>
    @else
        <br><br><div align="center"><h3>目前無訂單</h3></div>
    @endif
@endsection

<style>
    .button {
        display: inline-block;
        outline: 0;
        border: 0;
        cursor: pointer;
        background-color: white;
        border-radius: 4px;
        padding: 8px 16px;
        font-size: 16px;
        font-weight: 600;
        color: #2d3748;
        border: 1px solid #cbd5e0;
        line-height: 26px;
        box-shadow: 0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06);
    }
</style>
<script>
    function changeRecordsPerPage() {
        const select = document.getElementById('records-per-page');
        const value = select.options[select.selectedIndex].value;
        window.location.href = `{{ route('orders.index') }}?perPage=${value}`;
    }
</script>
