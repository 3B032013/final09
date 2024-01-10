@extends('admins.layouts.master')

@section('page-title', '意見檢視')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">意見檢視</h1>
        <div class="form-group">
            <label for="name" class="form-label">姓名</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name',$contact->name) }}" readonly>
        </div>
        <div class="form-group">
            <label for="phone" class="form-label">電話</label>
            <input id="phone" name="phone" type="text" class="form-control" value="{{ old('phone',$contact->phone) }}" readonly>
        </div>
        <div class="form-group">
            <label for="email" class="form-label">信箱</label>
            <input id="email" name="email" type="text" class="form-control" value="{{ old('email',$contact->email) }}" readonly>
        </div>
        <div class="form-group">
            <label for="title" class="form-label">標題</label>
            <input id="title" name="title" type="text" class="form-control" value="{{ old('title',$contact->title) }}" readonly>
        </div>
        <div class="form-group">
            <label for="content" class="form-label">內容</label>
            <input id="content" name="content" type="text" class="form-control" value="{{ old('content',$contact->content) }}" readonly>
        </div>
    </div>
@endsection
