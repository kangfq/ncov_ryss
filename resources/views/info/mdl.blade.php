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
                    <div class="card-header"><a href="/">首页</a> / 麦德龙菜单
                    </div>
                    <div class="card-body">
                                <h2>麦德龙菜单 2020.2.22</h2>
                                <img src="/vendor/menu/mdl.png" width="1000px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
