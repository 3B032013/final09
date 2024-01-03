@extends('admins.layouts.master')

@section('page-title', 'Create article')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">管理員等級管理</h1>
        <form action="{{ route('admins.users.store') }}" method="POST" role="form">
            @method('POST')
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">選擇使用者名稱</label>
                <select id="name" name="name" class="form-control" onchange="navigateToRoute(this.value)">
                    <option selected></option>
                    @foreach($users as $user)
                        <option value="{{ route('admins.admins.create_selected', ['id' => $user->id]) }}">{{ $user->name }}</option>
                    @endforeach
                </select>
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
