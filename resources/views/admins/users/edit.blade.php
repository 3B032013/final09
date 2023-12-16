@extends('admins.layouts.master')

@section('page-title', 'Edit article')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">用戶資料管理</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">編輯用戶資料</li>
        </ol>
        @include('admins.layouts.shared.errors')
        <form action="{{ route('admins.users.update',$user->id) }}" method="POST" role="form">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">姓名</label>
                <input id="name" name="name" type="text" class="form-control" value="{{ old('name',$user->name) }}" placeholder="請輸入姓名">
            </div>
            <div class="form-group">
                <label for="email" class="form-label">信箱</label>
                <input id="email" name="email" type="text" class="form-control" value="{{ old('email',$user->email) }}" placeholder="請輸入信箱">
            </div>
            <div class="form-group">
                <label for="password" class="form-label">密碼</label>
                <input id="password" name="password" type="text" class="form-control" value="{{ old('password',$user->password) }}" placeholder="請輸入密碼" readonly>
            </div>
            <div class="form-group">
                <label for="sex" class="form-label">性別</label>
                <select id="sex" name="sex" class="form-control">
                    @if($user->sex == '男')
                        <option value="男" selected>男</option>
                        <option value="女">女</option>
                    @elseif($user->sex == '女')
                        <option value="男">男</option>
                        <option value="女" selected>女</option>
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="birthday" class="form-label">生日</label>
                <input id="birthday" name="birthday" type="date" class="form-control" value="{{ old('birthday',$user->birthday) }}" placeholder="請輸入日期">
            </div>
            <div class="form-group">
                <label for="phone" class="form-label">電話</label>
                <input id="phone" name="phone" type="text" class="form-control" value="{{ old('phone',$user->phone) }}" placeholder="請輸入電話">
            </div>
            <div class="form-group">
                <label for="address" class="form-label">地址</label>
                <input id="address" name="address" type="text" class="form-control" value="{{ old('address',$user->address) }}" placeholder="請輸入地址">
            </div>
            <div class="form-group">
                <label for="bank_branch" class="form-label">分行代碼</label>
                <input id="bank_branch" name="bank_branch" type="text" class="form-control" value="{{ old('bank_branch',$user->bank_branch) }}" placeholder="請輸入分行代號">
            </div>
            <div class="form-group">
                <label for="bank_account" class="form-label">銀行帳號</label>
                <input id="bank_account" name="bank_account" type="text" class="form-control" value="{{ old('bank_account',$user->bank_account) }}" placeholder="請輸入地址">
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary btn-sm">儲存</button>
            </div>
        </form>
    </div>
@endsection
