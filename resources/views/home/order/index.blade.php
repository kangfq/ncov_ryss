@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">个人中心</a></li>
                <li class="breadcrumb-item active" aria-current="page">我的订单</li>
            </ol>
        </nav>
        <div class="row ">
            @foreach($orders as $order)
                <div class="col-md-4">
                    <div class="card" style="width: 92%; margin: 10px;">
                        <div class="card-header">
                            订单号:{{ $order['id'] }} 收货人:{{ $order['name'] }} {{ $order['tel'] }}
                        </div>
                        <div class="card-body">
                            <h6 class="card-subtitle mb-4">{{  $order['pro_text'] }}</h6>
                            <h6 class="card-subtitle mb-2 text-muted">商家:{{ $order['mall']->name }}
                                共{{ $order['total_num'] }}件 ￥{{ $order['total_money'] }}</h6>
                            <h6 class="card-subtitle mb-2 text-muted">下单时间 {{ $order['created_at'] }}</h6>
                            @if(is_null($order['pay_time']))
                                <span class="badge badge-warning">未付款</span>
                            @else
                                <span class="badge badge-success">已付款</span>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent ">
                            <form action="{{ route('order.success',$order['id']) }}" method="post" style="float:left;">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                                @if($order['is_success']===0)
                                    <button type="submit" class="btn btn-primary btn-sm">确认收货</button>
                                @else
                                    <button type="button" class="btn btn-success btn-sm">已经收货</button>
                                @endif
                            </form>
                            <form action="{{ route('order.destroy',$order['id']) }}" method="post"
                                  style="float:left;margin-left:10px;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-dark btn-sm">删除订单</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <hr>
        {{ $orders->links() }}
    </div>
@endsection
