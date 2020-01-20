@extends('layouts.profile')
@section('title','登録済プロフィールの一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>プロフィール一覧</h2>
        </div>
        <div class="row">
            <div class="list-news col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="10%">名前</th>
                                <th width="10%">性別</th>
                                <th width="20%">趣味</th>
                                <th width="20%">自己紹介</th>
                                <th width="10%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $profile)
                            <tr>
                                <th>{{ $profile->id }}</th>
                                <td>{{ str_limit($profile->name,10) }}</td>
                                <td>{{ str_limit($profile->gender,10) }}</td>
                                <td>{{ str_limit($profile->hobby,10) }}</td>
                                <td>{{ str_limit($profile->introduction,30) }}</td>
                                <td>
                                    <div>
                                        <a href="{{ action('Admin\ProfileController@edit',['id' =>$profile->id]) }}">編集</a>
                                    </div>
                                    <div>
                                        <a href="{{ action('Admin\ProfileController@delete',['id'=>  $profile->id]) }}">削除</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection