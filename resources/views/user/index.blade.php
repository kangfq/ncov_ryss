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
                    <div class="card-header"><a href="{{ route('home') }}">个人中心</a> / 用户管理 <span 　class="badge badge-pill badge-warning" style="float:right;">总用户数{{$count}}人</span></div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">name</th>
                                <th scope="col">tel</th>
                                <th scope="col">收货信息</th>
                                <th scope="col">管理权限</th>
                                <th scope="col">注册时间</th>
                                <th scope="col">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id}}</th>
                                    <th scope="row">{{ $user->name}}</th>
                                    <th scope="row">{{ $user->email}}</th>
                                    <th scope="row">@if($user->address->count()==0) <span class="badge badge-pill badge-danger">否</span> @else <span class="badge badge-pill badge-success">是</span> @endif</th>
                                    <th scope="row">{{ $user->is_admin}}</th>
                                    <th scope="row">{{ $user->created_at}}</th>
                                    <td><a href="javascript:;" onclick="document.getElementById('del_address_{{$user->id}}').submit()">删除收货信息</a>
                                        <form action="{{ route('address.destroy',$user->id) }}" method="post" id="del_address_{{ $user->id }}">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
