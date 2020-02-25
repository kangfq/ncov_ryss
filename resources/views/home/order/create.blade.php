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
                <li class="breadcrumb-item active" aria-current="page">{{ $mall->name }}商品选购</li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ $mall->name }}购物车</div>
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
                                @if($mall->is_show==0)
                                    <div class="alert alert-danger" role="alert">
                                        {{ $mall->name }}暂时未开放订菜，请留意群内通知！
                                    </div>
                                @endif
                                @if($mall->is_show==1)
                                    <button type="submit" class="btn btn-danger" id="submit">提交订单</button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @foreach($products as $product)
                <div class="con-md-4">
                    <div class="card" style="width: 22rem; margin: 10px;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">￥{{ $product->money }} 剩余库存：{{ $product->stock }}</h6>
                            <div class="form-group">
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="10"
                                          disabled>{{ $product->description }}</textarea>
                            </div>
                            <form action="{{route('cart.store')}}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="mall_id" value="{{ $mall->id }}">
                                <input type="hidden" name="num" value="1">
                                <button type="submit" class="btn btn-danger">加入购物车</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach


            {{--            <div class="col-md-6">--}}
            {{--                <div class="card">--}}
            {{--                    <div class="card-header">[{{$mall->name}}订菜] / <a--}}
            {{--                                href="{{ route('home') }}">个人中心</a></div>--}}
            {{--                    <div class="card-body">--}}
            {{--                        <form action="{{route('cart.store')}}" method="post">--}}
            {{--                            @csrf--}}
            {{--                            <div class="form-group">--}}
            {{--                                <label for="exampleFormControlSelect1">选择商品</label>--}}
            {{--                                <select class="form-control" id="exampleFormControlSelect1" name="product_id">--}}
            {{--                                    @foreach($products as $product)--}}
            {{--                                        <option value="{{ $product->id }}"--}}
            {{--                                                @if($product->stock<=0) disabled @endif>{{ $product->name }} /--}}
            {{--                                            ￥{{ $product->money }} / 库存剩余{{ $product->stock }} </option>--}}
            {{--                                    @endforeach--}}
            {{--                                </select>--}}
            {{--                            </div>--}}
            {{--                            <div class="form-group">--}}
            {{--                                <label for="exampleInputPassword1">购买数量</label>--}}
            {{--                                <select class="form-control" id="exampleFormControlSelect1" name="num">--}}
            {{--                                    <option value="1">1</option>--}}
            {{--                                    <option value="2">2</option>--}}
            {{--                                    <option value="3">3</option>--}}
            {{--                                    <option value="4">4</option>--}}
            {{--                                    <option value="5">5</option>--}}
            {{--                                </select>--}}
            {{--                            </div>--}}
            {{--                            <input type="hidden" value="{{ $mall_id }}" name="mall_id">--}}
            {{--                            <div class="form-text text-muted" style="color: red!important;">--}}
            {{--                                可以通过多次提交把商品加入购物车,加入完毕后请提交订单。--}}
            {{--                            </div>--}}
            {{--                            @if($mall->is_show==0)--}}
            {{--                                <div class="alert alert-danger" role="alert">--}}
            {{--                                    {{$mall->name}}暂时未开放订菜，请留意群内通知！--}}
            {{--                                </div>--}}
            {{--                            @endif--}}
            {{--                            @if($mall->is_show==1)--}}
            {{--                                <button type="submit" class="btn btn-primary">加入购物车</button>--}}
            {{--                            @endif--}}
            {{--                        </form>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}

        </div>
    </div>


@endsection
