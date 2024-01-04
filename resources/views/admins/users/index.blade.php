@extends('admins.layouts.master')

@section('page-title', 'Article list')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">用戶資料管理</h1>
        <div class="container px-4 px-lg-5 mt-2 mb-4">
            <form action="{{ route('admins.users.search') }}" method="GET" class="d-flex">
                <input type="text" name="query" class="form-control me-2" placeholder="關鍵字搜尋...">
                <button type="submit" class="btn btn-outline-dark">搜尋</button>
            </form>
        </div>
        @if (request()->has('query'))
            <div class="container px-4 px-lg-5 mt-2 mb-4">
                查找「{{ request('query') }}」
                <a class="btn btn-success btn-sm" href="{{ route('admins.users.index') }}">取消搜尋</a>
            </div>
        @endif
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('admins.users.create') }}">新增用戶</a>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col" style="text-align:left">姓名</th>
                <th scope="col" style="text-align:left">性別</th>
                <th scope="col" style="text-align:left">電子信箱</th>
                <th scope="col" style="text-align:left">身份</th>
                <th scope="col" style="text-align:left">地址</th>
                <th scope="col" style="text-align:left">生日</th>
                <th scope="col" style="text-align:left">電話</th>
                <th scope="col" style="text-align:center">修改</th>
                <th scope="col" style="text-align:center">刪除</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $index => $user)
                <tr>
                    <td style="text-align:left">{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->sex }}</td>
                    <td>{{ $user->email }}</td>
                    @if ($user->isadmin())
                        <td>
                            @if($user->admin->position == 1)
                                <div style="color:#FF0000;  font-weight:bold;">
                                    超級管理員
                                </div>
                            @elseif($user->admin->position == 2)
                                <div style="color:#FFB233;  font-weight:bold;">
                                    高階管理員
                                </div>
                            @else
                                <div style="color:#FFE333;  font-weight:bold;">
                                    一般管理員
                                </div>
                            @endif

                        </td>
                    @elseif($user->isseller())
                        <td>賣家</td>
                    @else
                        <td>一般會員</td>
                    @endif
                    <td>{{ $user->address }}</td>
                    <td>{{ $user->birthday }}</td>
                    <td>{{ $user->phone }}</td>
                    <td style="text-align:center">
                        <a href="{{ route('admins.users.edit',$user->id) }}" class="btn btn-secondary btn-sm">編輯</a>
                    </td>
                    <td style="text-align:center">
                        <form id="deleteForm{{ $user->id }}" action="{{ route('admins.users.destroy',$user->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $user->name }}', {{ $user->id }})">刪除</button>
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
                    <option value="5" {{ $users->perPage() == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $users->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $users->perPage() == 20 ? 'selected' : '' }}>20</option>
                </select>
                <span class="ml-1">筆</span>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            @if ($users->currentPage() > 1)
                <a href="{{ $users->previousPageUrl() }}" class="btn btn-secondary">上一頁</a>
            @endif

            <span class="mx-2">全部 {{ $users->total() }} 筆資料，目前位於第 {{ $users->currentPage() }} 頁，共 {{ $users->lastPage() }} 頁</span>

            @if ($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" class="btn btn-secondary">下一頁</a>
            @endif
        </div>
    </div>
    <script>
        function confirmDelete(username, userId)
        {
            if (confirm("確定要刪除使用者" + username + "嗎？")) {
                document.getElementById('deleteForm' + userId).submit();
            }
        }
    </script>
    <script>
        function changeRecordsPerPage() {
            const select = document.getElementById('records-per-page');
            const value = select.options[select.selectedIndex].value;
            window.location.href = `{{ route('admins.users.index') }}?perPage=${value}`;
        }
    </script>
@endsection
