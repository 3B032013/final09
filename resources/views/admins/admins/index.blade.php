@extends('admins.layouts.master')

@section('page-title', 'Article list')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">管理員管理</h1>
        {{--    <ol class="breadcrumb mb-4">--}}
        {{--        <li class="breadcrumb-item active">用戶一覽表</li>--}}
        {{--    </ol>--}}
        {{--    <div class="alert alert-success alert-dismissible" role="alert" id="liveAlert">--}}
        {{--        <strong>完成！</strong> 成功儲存用戶--}}
        {{--        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
        {{--    </div>--}}
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
                        <form action="{{ route('admins.admins.destroy',$admin->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">刪除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
