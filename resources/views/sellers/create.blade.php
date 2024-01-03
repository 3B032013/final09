@extends('layouts.master')

@section('title', 'Create ')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">申請成為賣家</h1>
        <form action="{{ route('sellers.store',$user->id) }}" method="POST" role="form">
            @method('POST')
            @csrf
            <input type ='hidden' name="status" value='3'>
            <input type ='hidden' name="user_id" value="{{ $user->id }}">
            <div class="container">
                <p>
                    <ui>
                        <li>盡可能提供多張實品物不同角度的照片，並拍出物品全貌、正反面、材質細節、所有配件.. 等。如果賣的是二手物，買家可能會把二手物的狀況問得很仔細。</li>
                        <li>拍照時，建議挑單色背景(白牆、單色桌面、單色地毯、單色沙發），不要拍到其他不相關的東西。</li>
                        <li>如果物品有瑕疵的部分，一定要特別拍出來，商品描述欄也要特別註明。避免買家收到物品後，卻發現物品不符合預期的狀況發生。</li>
                    </ui>

                </p>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary btn-sm">申請成為賣家</button>
            </div>
        </form>
    </div>


@endsection
