@extends('admins.layouts.master')

@section('page-title', '管理員管理')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">管理員管理
            @if(Auth::user()->admin->position == 1)
                目前職位：超級管理員
            @elseif(Auth::user()->admin->position == 2)
                目前職位：高階管理員
            @elseif(Auth::user()->admin->position == 3)
                目前職位：一般管理員
            @endif
        </h1>
        <div class="container px-4 px-lg-5 mt-2 mb-4">
            <form action="{{ route('admins.admins.search') }}" method="GET" class="d-flex">
                <input type="text" name="query" class="form-control me-2" placeholder="關鍵字搜尋...">
                <button type="submit" class="btn btn-outline-dark">搜尋</button>
            </form>
        </div>
        @if (request()->has('query'))
            <div class="container px-4 px-lg-5 mt-2 mb-4">
                查找「{{ request('query') }}」
                <a class="btn btn-success btn-sm" href="{{ route('admins.admins.index') }}">取消搜尋</a>
            </div>
        @endif
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('admins.admins.create') }}">新增管理員</a>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col" style="text-align:left">使用者id</th>
                <th scope="col" style="text-align:left">姓名</th>
                <th scope="col" style="text-align:left">階級</th>
                <th scope="col" style="text-align:left">電子信箱</th>
                <th scope="col" style="text-align:center">修改</th>
                <th scope="col" style="text-align:center">刪除</th>
            </tr>
            </thead>
            <tbody>
            @foreach($admins as $index => $admin)
                <tr>
                    <td style="text-align:left">{{ $index + 1 }}</td>
                    <td style="text-align:left">{{ $admin->user_id }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->position }}
                        @if ($admin->position == '3')
                            (一般管理員)
                        @elseif ($admin->position == '2')
                            (高階管理員)
                        @elseif ($admin->position == '1')
                            (超級管理員)
                        @endif
                    </td>
                    <td>{{ $admin->email }}</td>
                    <td style="text-align:center">
                        <a href="{{ route('admins.admins.edit',$admin->id) }}" class="btn btn-secondary btn-sm">編輯</a>
                    </td>
                    <td style="text-align:center">
                        <form id="deleteForm{{ $admin->id }}" action="{{ route('admins.admins.destroy',$admin->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $admin->name }}', {{ $admin->id }})">刪除</button>
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
                    <option value="5" {{ $admins->perPage() == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $admins->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $admins->perPage() == 20 ? 'selected' : '' }}>20</option>
                </select>
                <span class="ml-1">筆</span>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            @if ($admins->currentPage() > 1)
                <a href="{{ $admins->previousPageUrl() }}" class="btn btn-secondary">上一頁</a>
            @endif

            <span class="mx-2">全部 {{ $admins->total() }} 筆資料，目前位於第 {{ $admins->currentPage() }} 頁，共 {{ $admins->lastPage() }} 頁</span>

            @if ($admins->hasMorePages())
                <a href="{{ $admins->nextPageUrl() }}" class="btn btn-secondary">下一頁</a>
            @endif
        </div>
    </div>
    <script>
        function confirmDelete(admin_name, adminId)
        {
            if (confirm("確定要刪除管理員" + admin_name + "嗎？")) {
                document.getElementById('deleteForm' + adminId).submit();
            }
        }
    </script>
    <script>
        function changeRecordsPerPage() {
            const select = document.getElementById('records-per-page');
            const value = select.options[select.selectedIndex].value;
            window.location.href = `{{ route('admins.admins.index') }}?perPage=${value}`;
        }
    </script>
@endsection
