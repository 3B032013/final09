@extends('admins.layouts.master')

@section('page-title', 'Create article')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">管理員等級管理</h1>
        <form action="{{ route('admins.admins.store_level') }}" method="POST" role="form">
            @method('POST')
            @csrf
            <div class="form-group">
                <label for="account" class="form-label">選擇使用者帳號</label>
                <select id="account" name="account" class="form-control" onchange="navigateToRoute(this.value)">
                    @foreach($users as $user)
                        @if($user->name == $user_selected->name)
                            <option value="{{ route('admins.admins.create_selected', ['id' => $user->id]) }}" selected>{{ $user->name }}</option>
                        @else
                            <option value="{{ route('admins.admins.create_selected', ['id' => $user->id]) }}">{{ $user->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="position" class="form-label">職級</label>
                <select id="position" name="position" class="form-control">
                    <option value=4>使用者</option>
                    <option value=3>一般管理員</option>
                    <option value=2>高階管理員</option>
                </select>
            </div>
            <input type="hidden" name="user_id" id="user_id" value="{{ $user_selected->id }}">
            <div class="form-group">
                <label for="name" class="form-label">姓名</label>
                <input id="name" name="name" type="text" class="form-control" value="{{ old('name',$user_selected->name) }}" readonly>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">信箱</label>
                <input id="email" name="email" type="text" class="form-control" value="{{ old('email',$user_selected->email) }}" readonly>
            </div>
            <div class="form-group">
                <label for="sex" class="form-label">性別</label>
                <input id="sex" name="sex" type="text" class="form-control" value="{{ old('sex',$user_selected->sex) }}" readonly>
            </div>
            <div class="form-group">
                <label for="birthday" class="form-label">生日</label>
                <input id="birthday" name="birthday" type="text" class="form-control" value="{{ old('birthday',$user_selected->birthday) }}" readonly>
            </div>
            <div class="form-group">
                <label for="phone" class="form-label">電話</label>
                <input id="phone" name="phone" type="text" class="form-control" value="{{ old('phone',$user_selected->phone) }}" readonly>
            </div>
            <div class="form-group">
                <label for="address" class="form-label">地址</label>
                <input id="address" name="address" type="text" class="form-control" value="{{ old('address',$user_selected->address) }}" readonly>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary btn-sm">儲存</button>
            </div>
        </form>
    </div>

    <script>
        function navigateToRoute(selectedUserId) {
            if (selectedUserId) {
                window.location.href = selectedUserId;
            }
        }
    </script>
@endsection
