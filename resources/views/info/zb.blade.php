@extends('layouts.app')

@section('content')
    <link href="/vendor/common.css" rel="stylesheet">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><a href="/">首页</a> / 中百菜单
                    </div>
                    <div class="card-body">
                                <h2>中百菜单 2020.2.22</h2>
                                <img src="/vendor/menu/zb1.jpg" >
                                <img src="/vendor/menu/zb2.jpg" >
                                <img src="/vendor/menu/zb3.jpg" >
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
