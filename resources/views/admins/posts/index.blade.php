@extends('admins.layouts.master')

@section('page-title', '公告管理')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">公告管理</h1>
        <div class="container px-4 px-lg-5 mt-2 mb-4">
            <form action="{{ route('admins.posts.search') }}" method="GET" class="d-flex">
                <input type="text" name="query" class="form-control me-2" placeholder="關鍵字搜尋...">
                <button type="submit" class="btn btn-outline-dark">搜尋</button>
            </form>
        </div>
        @if (request()->has('query'))
            <div class="container px-4 px-lg-5 mt-2 mb-4">
                查找「{{ request('query') }}」
                <a class="btn btn-success btn-sm" href="{{ route('admins.posts.index') }}">取消搜尋</a>
            </div>
        @endif
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('admins.posts.create') }}">新增</a>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col" style="text-align:center">#</th>
                <th scope="col" style="text-align:center">標題</th>
                <th scope="col" style="text-align:center">內容</th>
                <th scope="col" style="text-align:center">公告更動時間</th>
                <th scope="col" style="text-align:center">狀態</th>
                <th scope="col" style="text-align:center">功能</th>
                <th scope="col" style="text-align:center">刪除</th>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $index => $post)
                <tr>
                    <td style="text-align:center">{{ $index + 1 }}</td>
                    <td style="text-align:center">{{ $post->title }}</td>
                    <td style="text-align:center">{{$post->content}}</td>
                    <td style="text-align:center">{{$post->updated_at}}</td>
                    <td style="text-align:center">
                        @if ($post->status == 0)
                            未上架
                        @elseif ($post->status == 1)
                            已上架
                        @endif
                    </td>
                    <td style="text-align:center">
                        @if ($post->status == 0)
                            <form action="{{ route('admins.posts.statusOn',$post->id) }}" method="POST" role="form">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">上架</button>
                            </form>
                            <a href="{{ route('admins.posts.edit',$post->id) }}" class="btn btn-primary btn-sm">編輯</a>
                        @elseif ($post->status == 1)
                            <form action="{{ route('admins.posts.statusOff',$post->id) }}" method="POST" role="form">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">下架</button>
                            </form>
                        @endif
                    </td>
                    <td style="text-align:center">
                        <form id="deleteForm{{ $post->id }}" action="{{ route('admins.posts.destroy',$post->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $post->name }}', {{ $post->id }})">刪除</button>
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
                    <option value="5" {{ $posts->perPage() == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $posts->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $posts->perPage() == 20 ? 'selected' : '' }}>20</option>
                </select>
                <span class="ml-1">筆</span>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            @if ($posts->currentPage() > 1)
                <a href="{{ $posts->previousPageUrl() }}" class="btn btn-secondary">上一頁</a>
            @endif

            <span class="mx-2">全部 {{ $posts->total() }} 筆資料，目前位於第 {{ $posts->currentPage() }} 頁，共 {{ $posts->lastPage() }} 頁</span>

            @if ($posts->hasMorePages())
                <a href="{{ $posts->nextPageUrl() }}" class="btn btn-secondary">下一頁</a>
            @endif
        </div>
    </div>
    <script>
        function confirmDelete(post_name, postId)
        {
            if (confirm("確定要刪除公告" + post_name + "嗎？")) {
                document.getElementById('deleteForm' + postId).submit();
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
