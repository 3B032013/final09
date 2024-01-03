@extends('layouts.master')

@section('title', $post->title)

@section('content')
    <hr>
    <div class="container">
        <div class="card mx-auto mt-5" style="width: 50%;">
            <div class="card-body">
                <h2 class="card-title">{{ $post->title }}</h2>
                <p class="card-text">發佈日期：{{ $post->updated_at }}</p>
                <div class="card-text">
                    {{ $post->content }}
                </div>
            </div>
        </div>
    </div>
@endsection

