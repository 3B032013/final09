@extends('admins.layouts.master')

@section('page-title', 'Edit article')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">賣家審核</h1>
        @include('admins.layouts.shared.errors')
            <div class="form-group">
                <label for="name" class="form-label">姓名</label>
                <input id="name" name="name" type="text" class="form-control" value="{{ old('name',$seller->user->name) }}" readonly>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">信箱</label>
                <input id="email" name="email" type="text" class="form-control" value="{{ old('email',$seller->user->email) }}" readonly>
            </div>
            <div class="form-group">
                <label for="address" class="form-label">地址</label>
                <input id="address" name="address" type="text" class="form-control" value="{{ old('address',$seller->user->address) }}" readonly>
            </div>
            <div class="form-group">
                <label for="phone" class="form-label">電話</label>
                <input id="phone" name="phone" type="text" class="form-control" value="{{ old('phone',$seller->user->phone) }}" readonly>
            </div>
            <div class="form-group">
                <label for="bank_branch" class="form-label">分行代碼</label>
                <input id="bank_branch" name="bank_branch" type="text" class="form-control" value="{{ old('bank_branch',$seller->user->bank_branch) }}" readonly>
            </div>
            <div class="form-group">
                <label for="bank_account" class="form-label">銀行帳戶</label>
                <input id="bank_account" name="bank_account" type="text" class="form-control" value="{{ old('sex',$seller->user->bank_account) }}" readonly>
            </div>
        <form action="{{ route('admins.sellers.pass',$seller->id) }}" method="POST" role="form">
            @method('PATCH')
            @csrf
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary btn-sm">通過申請</button>
            </div>
        </form>
        <form action="{{ route('admins.sellers.unpass',$seller->id) }}" method="POST" role="form">
            @method('PATCH')
            @csrf
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary btn-sm">不通過申請</button>
            </div>
        </form>
    </div>
@endsection
