@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <ul class="list-group">
                    <li class="list-group-item active">个人中心</li>
                    <a href="{{ route('address.index') }}">
                        <li class="list-group-item">收货信息管理</li>
                    </a>
                    @foreach($malls as $mall)
                    <a href="{{ route('order.create',$mall->id) }}">
                        <li class="list-group-item">开始购物[{{ $mall->name }}]</li>
                    </a>
                    @endforeach
                    <a href="{{ route('order.index') }}">
                        <li class="list-group-item">我的订单</li>
                    </a>
                    @if(Auth()->check())
                        @if(Auth()->user()->is_admin==1)
                            <a href="{{ route('admin.index') }}">
                                <li class="list-group-item">管理入口</li>
                            </a>
                        @endif
                    @endif
                </ul>

            </div>
        </div>
    </div>
@endsection
