@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if($mall->is_show==0)
            <div class="alert alert-danger" role="alert">
                {{ $mall->name }}暂时未开放订菜，请留意群内通知！
            </div>
        @endif
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">首页</a></li>
                <li class="breadcrumb-item"><a href="{{ route('home') }}">个人中心</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $mall->name }}购物车</li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-header">{{ $mall->name }}购物车</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                            <tr>
                                <th scope="col">序号</th>
                                <th scope="col">商品</th>
                                <th scope="col">单价</th>
                                <th scope="col">数量</th>
                                <th scope="col">总金额</th>
                                <th scope="col">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($carts as $cart)
                                <tr>
                                    <th scope="row">{{ $cart->id }}</th>
                                    @if(!is_null($cart->product))
                                        <td>{{ $cart->product->name  }}</td>
                                        <td>￥{{  $cart->product->money }}</td>
                                        <td>{{ $cart->total_num }}</td>
                                        <td>￥{{ $cart->total_num * $cart->product->money }}</td>
                                    @else
                                        <td>无效商品</td>
                                        <td>无效商品</td>
                                        <td>{{ $cart->total_num }}</td>
                                        <td>无效商品</td>
                                    @endif

                                    <td><a href="javascript:;"
                                           onclick="document.getElementById('del_{{ $cart->id}}').submit()">删除</a>
                                        <div style="display: none">
                                            <form action="{{ route('cart.destroy',$cart->id) }}" method="post"
                                                  id="del_{{ $cart->id }}">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-header">合计金额：￥{{ $total_price }}</div>
                    <div class="card-header">
                        <form action="{{ route('order.store') }}" method="post">
                            @csrf
                            <input type="hidden" value="{{ $mall->id }}" name="mall_id">
                            @if($mall->is_show==0)
                                <div class="alert alert-danger" role="alert">
                                    {{ $mall->name }}暂时未开放订菜，请留意群内通知！
                                </div>
                            @endif
                            @if($mall->is_show==1)
                                <a href="{{ route('order.create',$mall->id) }}">
                                    <button type="button" class="btn btn-primary">继续购物</button>
                                </a>
                                <button type="submit" class="btn btn-danger" id="submit">提交订单</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
