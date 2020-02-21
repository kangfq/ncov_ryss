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
                    <div class="card-header"><a href="/">首页</a> / 信息公开 / <a href="{{ route('info.buy') }}">购物信息</a></div>
                    <div class="card-body">
                        物业电话:15971436290  社区电话:（027）61880180
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
