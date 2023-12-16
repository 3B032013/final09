@extends('admins.layouts.master')

@section('page-title', 'Article list')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">賣家管理</h1>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col" style="text-align:left">姓名</th>
                <th scope="col" style="text-align:left">電子信箱</th>
                <th scope="col" style="text-align:left">狀態</th>
                <th scope="col" style="text-align:center">修改</th>
                <th scope="col" style="text-align:center">刪除</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sellers as $index => $seller)
                <tr>
                    <td style="text-align:left">{{ $index + 1 }}</td>
                    <td>{{ $seller->name }}</td>
                    <td>{{ $seller->email }}</td>
                    <td>{{ $seller->status }}
                        @if ($seller->status == 0)
                            (申請未通過)
                        @elseif ($seller->status == 1)
                            (停權)
                        @elseif ($seller->status == 2)
                            (正式賣家)
                        @elseif ($seller->status == 3)
                            (申請中)
                        @endif
                    </td>
                    <td style="text-align:center">
                        @if ($seller->status == 0)

                        @elseif ($seller->status == 1)
                            <form action="{{ route('admins.sellers.statusOn',$seller->id) }}" method="POST" role="form">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">啟用</button>
                            </form>
                        @elseif ($seller->status == 2)
                            <form action="{{ route('admins.sellers.statusOff',$seller->id) }}" method="POST" role="form">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">停權</button>
                            </form>
                        @elseif ($seller->status == 3)
                            <a href="{{ route('admins.sellers.edit',$seller->id) }}" class="btn btn-secondary btn-sm">審核申請</a>
                        @endif
                    </td>
                    <td style="text-align:center">
                        <form action="{{ route('admins.sellers.destroy',$seller->id) }}" method="POST">
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
