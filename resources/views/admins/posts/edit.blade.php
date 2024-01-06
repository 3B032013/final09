@extends('admins.layouts.master')

@section('page-title', '編輯公告 - '.$post->title)

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">公告管理</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">編輯公告</li>
        </ol>
        @include('admins.layouts.shared.errors')
        <form action="{{ route('admins.posts.update',$post->id) }}" method="POST" role="form" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="title" class="form-label">文章標題</label>
                <input id="title" name="title" type="text" class="form-control"  value="{{ old('title',$post->title) }}">
            </div>
            <div class="form-group">
                <label for="content" class="form-label">文章內容</label>
                <textarea id="content" name="content" class="form-control" rows="10" >{{ old('content',$post->content) }}</textarea>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary btn-sm">儲存</button>
            </div>
        </form>
    </div>
@endsection
