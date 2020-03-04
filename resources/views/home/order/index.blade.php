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
                            <h6 class="card-subtitle mb-2 text-muted">共{{ $order['total_num'] }}件
                                ￥{{ $order['total_money'] }}</h6>
                            <h6 class="card-subtitle mb-2 text-muted">下单时间 {{ $order['created_at'] }}</h6>
                            @if(is_null($order['pay_time']))
                                <span class="badge badge-warning" style="font-size: 85%!important;">未付款</span>
                            @else
                                <span class="badge badge-danger"
                                      style="margin-right: 5px;font-size: 85%!important;">商家：{{ $order['mall']->name }}</span>
                                <span class="badge badge-success" style="font-size: 85%!important;">已付款</span>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent ">
                            @if($order['is_success']===0)
                                @if(is_null($order['pay_time']))
                                    <button type="button" class="btn btn-danger btn-sm"
                                            style="float:left;margin-right: 10px;" data-toggle="modal"
                                            data-target="#order_pay_{{ $order->id }}">立即付款
                                    </button>
                                @else
                                    <form action="{{ route('order.success',$order['id']) }}" method="post"
                                          style="float:left;margin-right:10px;">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                                        <button type="submit" class="btn btn-primary btn-sm">确认收货</button>
                                    </form>
                                @endif
                                @if(is_null($order['pay_time']))
                                    <form action="{{ route('order.destroy',$order['id']) }}" method="post"
                                          style="float:left;margin-right: 10px;">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-dark btn-sm">删除订单</button>
                                    </form>
                                @endif
                            @else
                                <button type="button" class="btn btn-success btn-sm" disabled style="cursor: default;">
                                    已经收货
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <hr>
        {{ $orders->links() }}
    </div>
    @foreach($orders as $order)
        <div class="modal fade" id="order_pay_{{ $order->id }}" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="order_success" aria-hidden="true">
            <div class="modal-dialog modal-sm " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">付款方式</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <img src="{{$order->mall->pay_qrcode}}" class="card-img-top img-responsive center-block">
                            <div class="card-body">
                                <h6 class="card-title">加好友付款需知</h6>
                                <p class="card-text">订单号+姓名+电话+金额 然后转账</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
