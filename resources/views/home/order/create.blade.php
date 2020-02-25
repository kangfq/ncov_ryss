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
                <li class="breadcrumb-item"><a href="{{ route('cart.index',$mall->id) }}">我的购物车</a></li>
            </ol>
        </nav>
        <div class="row justify-content-center">
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
                                <button type="submit" class="btn btn-danger"  onclick="alert('点击继续……')" @if($mall->is_show==0 || $product->stock <=0)
                                   disabled
                                @endif>加入购物车</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


@endsection
