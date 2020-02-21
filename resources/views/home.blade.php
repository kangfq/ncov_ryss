@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="gere">
                    <div class="card-header">
                        个人中心
                    </div>
                    <div class="card-body" style="color: red;">
                       本系统只可以订盘龙城麦德龙商城的菜,请大家注意!
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="{{ route('address.index') }}">收货信息管理</a></li>
                        <li class="list-group-item"><a href="{{ route('order.create') }}">开始订菜</a></li>
                        <li class="list-group-item"><a href="{{ route('order.index') }}">订单查看</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
