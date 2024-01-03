@extends('admins.layouts.master')

@section('page-title', '訂單管理')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">訂單管理</h1>
        <div class="container px-4 px-lg-5 mt-2 mb-4">
            <form action="{{ route('admins.orders.search') }}" method="GET" class="d-flex">
                <input type="text" name="query" class="form-control me-2" placeholder="關鍵字搜尋...">
                <button type="submit" class="btn btn-outline-dark">搜尋</button>
            </form>
        </div>
        @if (request()->has('query'))
            <div class="container px-4 px-lg-5 mt-2 mb-4">
                查找「{{ request('query') }}」
                <a class="btn btn-success btn-sm" href="{{ route('admins.orders.index') }}">取消搜尋</a>
            </div>
        @endif
        <table class="table">
            <thead>
            <tr>
                <th scope="col" style="text-align:left">#</th>
                <th scope="col" style="text-align:left">買家</th>
                <th scope="col" style="text-align:left">賣家</th>
                <th scope="col" style="text-align:left">訂單日期</th>
                <th scope="col" style="text-align:left">訂單狀態</th>
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
                    <td> @if ($order->status == '0')
                            <div style="color:#8d00ff; font-weight:bold;">
                                (未付款)
                            </div>
                        @elseif ($order->status == '1')
                            <div style="color:#FF0000; font-weight:bold;">
                                (待確認)
                            </div>
                        @elseif ($order->status == '2')
                            <div style="color:#ff6f00; font-weight:bold;">
                                (出貨中)
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
                        @elseif ($order->status == '6')
                            <div style="color:#002aff; font-weight:bold;">
                                (退貨)
                            </div>
                        @elseif ($order->status == '7')
                            <div style="color:#002aff; font-weight:bold;">
                                (取消)
                            </div>
                        @elseif ($order->status == '8')
                            <div style="color:#002aff; font-weight:bold;">
                                (未成立)
                            </div>

                        @endif</td>
                    <td style="text-align:center">
                        <a href="{{ route('admins.orders.show',$order->id) }}" class="btn btn-secondary btn-sm">檢視</a>
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
    </div>
    <script>
        function changeRecordsPerPage() {
            const select = document.getElementById('records-per-page');
            const value = select.options[select.selectedIndex].value;
            window.location.href = `{{ route('admins.orders.index') }}?perPage=${value}`;
        }
    </script>
@endsection
