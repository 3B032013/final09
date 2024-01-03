@extends('admins.layouts.master')

@section('page-title', '公告管理')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">公告管理</h1>
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
                        <a href="{{ route('admins.posts.edit',$post->id) }}" class="btn btn-primary btn-sm">編輯</a>
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
    </div>
@endsection
