@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if($state==0)
            <div class="alert alert-danger" role="alert">
                @if($mall_id ==1) 麦德龙 @else 中百@endif暂时未开放订菜，请留意群内通知！
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">[@if($mall_id ==1) 麦德龙订菜 @else 中百订菜@endif] / <a
                                href="{{ route('home') }}">个人中心</a> / <a
                                href="{{ route('order.create') }}">麦德龙订菜</a> /
                        <a href="{{ route('info.mdl') }}"
                           target="_blank">麦德龙菜单</a> / <a
                                href="{{ route('order.zbcreate') }}">中百订菜</a> / <a href="{{ route('info.zb') }}" target="_blank">中百菜单</a></div>
                    <div class="card-body">
                        <form action="{{route('cart.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">选择商品</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="product_id">
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}"
                                                @if($product->stock<=0) disabled @endif>{{ $product->name }} /
                                            ￥{{ $product->money }} / 库存剩余{{ $product->stock }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">购买数量</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="num">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <input type="hidden" value="{{ $mall_id }}" name="mall_id">
                            <div class="form-text text-muted" style="color: red!important;">
                                可以通过多次提交把商品加入购物车,加入完毕后请提交订单。
                            </div>
                            @if($state==0)
                                <div class="alert alert-danger" role="alert">
                                    @if($mall_id ==1) 麦德龙 @else 中百@endif暂时未开放订菜，请留意群内通知！
                                </div>
                            @endif
                            @if($state==1)
                                <button type="submit" class="btn btn-primary">加入购物车</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">@if($mall_id ==1) 麦德龙@else 中百@endif购物车</div>
                    <div class="card-body">
                        <table class="table">
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
                                    <td>{{ $cart->product->name }}</td>
                                    <td>￥{{  $cart->product->money }}</td>
                                    <td>{{ $cart->total_num }}</td>
                                    <td>￥{{ $cart->total_num * $cart->product->money }}</td>
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
                        <div class="card-header">合计金额：￥{{ $total_price }}</div>
                        <div class="card-header">
                            <form action="{{ route('order.store') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ $mall_id }}" name="mall_id">
                                @if($state==0)
                                    <div class="alert alert-danger" role="alert">
                                        @if($mall_id ==1) 麦德龙 @else 中百@endif暂时未开放订菜，请留意群内通知！
                                    </div>
                                @endif
                                @if($state==1)
                                    <button type="submit" class="btn btn-danger">提交订单</button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
