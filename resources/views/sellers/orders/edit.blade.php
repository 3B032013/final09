@extends('sellers.layouts.master')

@section('page-title', 'Edit article')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">訂單管理</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">編輯訂單資料</li>
        </ol>
        @include('sellers.layouts.shared.errors')
        <div class="form-group">
            <label for="name" class="form-label">收件人名稱</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name',$order->user->name) }}" readonly>
        </div>
        <div class="form-group">
            <label for="phone" class="form-label">收件人電話</label>
            <input id="receiver_phone" name="receiver_phone" type="text" class="form-control" value="{{ old('receiver_phone',$order->receiver_phone) }}" readonly>
        </div>
        <div class="form-group">
            <label for="receiver_address" class="form-label">收件人地址</label>
            <input id="receiver_address" name="receiver_address" type="text" class="form-control" value="{{ old('receiver_address',$order->receiver_address) }}" placeholder="請輸入內容" readonly>
        </div>
        <div class="form-group">
            <label for="price" class="form-label">訂單金額</label>
            <input id="price" name="price" type="text" class="form-control" value="{{ old('price',$order->price) }}" placeholder="請輸入價格" readonly>
        </div>
        <div class="form-group">
            <label for="status" class="form-label">狀態</label>
                @if ($order->status == '1')
                    <div style="color:#FF0000; font-weight:bold;">
                        (待確認)
                        @if($order->status=='1')
                            <form action="{{ route('sellers.orders.pass',$order->id) }}" method="POST" role="form">
                                @method('PATCH')
                                @csrf
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary btn-sm">接受訂單</button>
                                </div>
                            </form>

                            <form action="{{ route('sellers.orders.unpass',$order->id) }}" method="POST" role="form">
                                @method('PATCH')
                                @csrf
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary btn-sm">不接受訂單</button>
                                </div>
                            </form>
                        @endif
                    </div>
                @elseif ($order->status == '2')
                    <div style="color:#ff6f00; font-weight:bold;">
                        (發貨中)
                        <form action="{{ route('sellers.orders.transport',$order->id) }}" method="POST" role="form">
                            @method('PATCH')
                            @csrf
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary btn-sm">出貨</button>
                            </div>
                        </form>
                    </div>
                @elseif ($order->status == '3')
                    <div style="color:#ffea00; font-weight:bold;">
                        (已出貨)
                        <form action="{{ route('sellers.orders.arrive',$order->id) }}" method="POST" role="form">
                            @method('PATCH')
                            @csrf
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary btn-sm">已送達</button>
                            </div>
                        </form>
                    </div>
                @elseif ($order->status == '4')
                    <div style="color:#48ff00; font-weight:bold;">
                        (已送達)
                    </div>
                @elseif ($order->status == '5')
                    <div style="color:#002aff; font-weight:bold;">
                        (已完成)
                        <form action="{{ route('sellers.message.edit',$order->id) }}" method="GET" role="form">
                            @method('GET')
                            @csrf
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary btn-sm">評價</button>
                            </div>
                        </form>
                    </div>
                @elseif ($order->status == '6')
                    <div style="color:#002aff; font-weight:bold;">
                        (退貨)
                    </div>
                @elseif ($order->status == '7')
                    <div style="color:#002aff; font-weight:bold;">
                        <form action="{{ route('sellers.orders.cancel',$order->id) }}" method="POST" role="form">
                            @method('PATCH')
                            @csrf
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary btn-sm">同意</button>
                            </div>
                        </form>

                        <form action="{{ route('sellers.orders.notcancel',$order->id) }}" method="POST" role="form">
                            @method('PATCH')
                            @csrf
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary btn-sm">不同意</button>
                            </div>
                        </form>
                    </div>
                @elseif ($order->status == '8')
                    <div style="color:#002aff; font-weight:bold;">
                        (未成立)
                    </div>

                @endif

        </div>

    </div>
    <script>
        function previewImage(input) {
            var preview = document.getElementById('image-preview');
            var file = input.files[0];
            var reader = new FileReader();
            reader.onloadend = function () {
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        }
    </script>
@endsection
