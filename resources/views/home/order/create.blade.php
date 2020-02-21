@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row justify-content-center">

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><a
                                href="{{ route('home') }}">个人中心</a> / 开始订菜 / <a href="/vendor/product.png"
                                                                                target="_blank">查看菜单</a></div>

                    <div class="card-body">
                        <form action="{{route('cart.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">选择商品</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="product_id">
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}
                                            ￥{{ $product->money }}</option>
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
                            <div class="form-text text-muted" style="color: red!important;">
                                可以通过多次提交把商品加入购物车,加入完毕后请提交订单。
                            </div>
                            <button type="submit" class="btn btn-primary">加入购物车</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">当前购物车</div>
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
                                <button type="submit" class="btn btn-danger">提交订单</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
