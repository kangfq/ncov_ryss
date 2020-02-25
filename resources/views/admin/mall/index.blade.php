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
                    <div class="card-header"><a href="{{ route('home') }}">个人中心</a> / 商户管理</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">商户名称</th>
                                <th scope="col">营业状态</th>
                                <th scope="col">创建时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($malls as $mall)
                                <tr>
                                    <th scope="row">{{ $mall->id}}</th>
                                    <th scope="row">{{ $mall->name}}</th>
                                    <th scope="row">{{ $mall->is_show}}</th>
                                    <th scope="row">{{ $mall->created_at}}</th>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
