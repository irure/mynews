{{-- layouts/admin.blade.phpを読みこむ--}}
@extends('layouts.profile')

{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成を埋め込む'--}}
@section('title','Myプロフィール')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む--}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>My プロフィール</h2>
            </div>
        </div>
    </div>
@endsection