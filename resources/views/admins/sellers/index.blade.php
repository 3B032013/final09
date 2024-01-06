@extends('admins.layouts.master')

@section('page-title', '賣家管理')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">賣家管理</h1>
        <div class="container px-4 px-lg-5 mt-2 mb-4">
            <form action="{{ route('admins.sellers.search') }}" method="GET" class="d-flex">
                <input type="text" name="query" class="form-control me-2" placeholder="關鍵字搜尋...">
                <button type="submit" class="btn btn-outline-dark">搜尋</button>
            </form>
        </div>
        @if (request()->has('query'))
            <div class="container px-4 px-lg-5 mt-2 mb-4">
                查找「{{ request('query') }}」
                <a class="btn btn-success btn-sm" href="{{ route('admins.sellers.index') }}">取消搜尋</a>
            </div>
        @endif
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col" style="text-align:left">姓名</th>
                <th scope="col" style="text-align:left">電子信箱</th>
                <th scope="col" style="text-align:left">狀態</th>
                <th scope="col" style="text-align:center">修改</th>
{{--                <th scope="col" style="text-align:center">刪除</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($sellers as $index => $seller)
                <tr>
                    <td style="text-align:left">{{ $index + 1 }}</td>
                    <td>{{ $seller->name }}</td>
                    <td>{{ $seller->email }}</td>
                    <td>{{ $seller->status }}
                        @if ($seller->status == 0)
                            (申請未通過)
                        @elseif ($seller->status == 1)
                            (停權)
                        @elseif ($seller->status == 2)
                            (正式賣家)
                        @elseif ($seller->status == 3)
                            (申請中)
                        @endif
                    </td>
                    <td style="text-align:center">
                        @if ($seller->status == 0)

                        @elseif ($seller->status == 1)
                            <form action="{{ route('admins.sellers.statusOn',$seller->id) }}" method="POST" role="form">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">啟用</button>
                            </form>
                        @elseif ($seller->status == 2)
                            <form action="{{ route('admins.sellers.statusOff',$seller->id) }}" method="POST" role="form">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">停權</button>
                            </form>
                        @elseif ($seller->status == 3)
                            <a href="{{ route('admins.sellers.edit',$seller->id) }}" class="btn btn-secondary btn-sm">審核申請</a>
                        @endif
                    </td>
{{--                    <td style="text-align:center">--}}
{{--                        <form action="{{ route('admins.sellers.destroy',$seller->id) }}" method="POST">--}}
{{--                            @method('DELETE')--}}
{{--                            @csrf--}}
{{--                            <button type="submit" class="btn btn-danger btn-sm">刪除</button>--}}
{{--                        </form>--}}
{{--                    </td>--}}
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="d-flex align-items-center">
                <span class="mr-1">每</span>
                <select id="records-per-page" class="form-control" onchange="changeRecordsPerPage()">
                    <option value="5" {{ $sellers->perPage() == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $sellers->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $sellers->perPage() == 20 ? 'selected' : '' }}>20</option>
                </select>
                <span class="ml-1">筆</span>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            @if ($sellers->currentPage() > 1)
                <a href="{{ $sellers->previousPageUrl() }}" class="btn btn-secondary">上一頁</a>
            @endif

            <span class="mx-2">全部 {{ $sellers->total() }} 筆資料，目前位於第 {{ $sellers->currentPage() }} 頁，共 {{ $sellers->lastPage() }} 頁</span>

            @if ($sellers->hasMorePages())
                <a href="{{ $sellers->nextPageUrl() }}" class="btn btn-secondary">下一頁</a>
            @endif
        </div>
    </div>
    <script>
        function changeRecordsPerPage() {
            const select = document.getElementById('records-per-page');
            const value = select.options[select.selectedIndex].value;
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('perPage', value);
            window.location.href = currentUrl.href;
        }
    </script>
@endsection
