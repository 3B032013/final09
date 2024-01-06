@extends('products.index.layouts.master')

@section('title', '編輯訂單評論')

@section('page-path')
    <div>
        <p style="font-size: 1.2em;"><a href="{{ route('home') }}">
                <i class="fa fa-home"></i></a> &gt; <a href="{{ route('orders.index') }}" class="custom-link">訂購清單</a> >
            <a href="{{ route('orders.show',$order->id) }}" class="custom-link">訂單 {{ $order->id }}</a> > 修改評論
        </p>
    </div>
@endsection

@section('content')
    <hr>
    <div class="wrapper">
        <div class="container mt-8">
            <h3 class="text-2xl mb-4" align="center">評論訂單</h3>
        </div>
    </div>
    <form action="{{ route('comments.update',$order->id) }}" method="POST" role="form">
        @method('PATCH')
        @csrf
        <table class="min-w-full bg-white border border-gray-200 mx-auto" border="1">
            <tbody>
            <tr>
                <td  style="width: 415px" align="center">
                    <br><div class='form-row row'>
                        <div class="form-group">
                            <label for="seller_rating" class="form-label">滿意度</label>
                            <div class="rating d-flex justify-content-center mb-4">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="comment_rating" value="{{ $i }}" {{ old('buyer_rating', optional($order->comment)->buyer_rating) == $i ? 'checked' : '' }}>
                                    <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                @endfor
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td><div class="text-center"><hr></div></td>
            </tr>
            <tr>
                <td  style="width: 415px">
                    <div class='form-row row'>
                        <div class='col-xs-12 form-group required'>
                            <label for="buyer_message" class="form-label">輸入評論內容</label>
                            <textarea id="buyer_message" name="buyer_message" class="form-control" rows="10" placeholder="請輸入文章內容">
                            {{ old('buyer_message', optional($order->comment)->buyer_message) }}</textarea>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td><div class="text-center"><hr></div></td>
            </tr>
            <tr>
                <td align="right">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary btn-sm">儲存評論</button><br><br>
                    </div><br>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
@endsection

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
<style>
    .rating {
        display: flex;
        flex-direction: row-reverse;
    }

    .rating input {
        display: none;
    }

    .rating label {
        cursor: pointer;
        font-size: 1.5em;
        color: #ddd;
    }

    .rating input:checked ~ label {
        color: #ffc107;
    }
</style>
