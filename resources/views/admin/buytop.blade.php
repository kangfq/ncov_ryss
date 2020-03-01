@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><a href="{{ route('home') }}">个人中心</a> / 消费排行</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">用户名</th>
                                <th scope="col">手机号</th>
                                <th scope="col">消费金额</th>
                                <th scope="col">注册时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id}}</th>
                                    <th scope="row">{{ $user->name}}</th>
                                    <th scope="row">{{ $user->email}}</th>
                                    <th scope="row">￥{{ sprintf("%.2f",$user->total_money)}}</th>
                                    <th scope="row">{{ $user->created_at}}</th>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
            {{ $users->links() }}
    </div>
@endsection
