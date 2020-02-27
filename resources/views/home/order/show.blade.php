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
                <li class="breadcrumb-item"><a href="/">首页</a></li>
                <li class="breadcrumb-item"><a href="{{ route('order.index') }}">我的订单</a></li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        订单号:{{ $order->id }} 收货人:{{ $order->name }} {{ $order->tel }}
                    </div>
                    <div class="card-body">
                        <h6 class="card-subtitle mb-4">{{  $order->pro_text }}</h6>
                        <h6 class="card-subtitle mb-2 text-muted">商家:{{ $order->mall->name }}
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
        </div>
    </div>

    @if (session('pay_success'))
        <div class="modal fade" id="order_success" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="order_success" aria-hidden="true">
            <div class="modal-dialog modal-sm " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"> {{ session('pay_success') }}</h5>
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
    @endif
@endsection
@section('js')
    <script type="text/javascript">
        $(function () {
            $("#order_success").modal('show');
        })
    </script>
@endsection
