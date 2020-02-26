@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('pay_success'))
            <div class="modal fade" id="order_success" data-backdrop="static" tabindex="-1" role="dialog"
                 aria-labelledby="order_success" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel"> {{ session('pay_success') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <img src="{{$order->mall->pay_qrcode}}" class="card-img-top" alt="..." style="width:90%;">
                                <div class="card-body">
                                    <h5 class="card-title">加好友付款需知</h5>
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
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><a href="{{ route('order.index') }}">我的订单</a></div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">订单号</th>
                                <th scope="col">商家</th>
                                <th scope="col">下单时间</th>
                                <th scope="col">商品</th>
                                <th scope="col">订单总金额</th>
                                <th scope="col">商品件数</th>
                                <th scope="col">支付时间</th>
                                <th scope="col">收货状态</th>
                                <th scope="col">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">{{ $order->id }}</th>
                                <th scope="row">{{ $order->mall->name }}</th>
                                <th scope="row">{{ $order->created_at }}</th>
                                <td>{{ $pro_text }}</td>
                                <td>￥{{ $order->total_money }}</td>
                                <td>{{ $order->total_num }}</td>
                                <td>{{ $order->pay_time }}</td>
                                <td>@if($order->is_success===0) <a href="javascript:;">
                                        <button class="btn btn-sm btn-primary" type="button"
                                                onclick="document.getElementById('success_order').submit()">确认收货
                                        </button>
                                    </a> @else 已收货 @endif</td>
                                <td><a href="javascript:;">
                                        <button class="btn btn-sm btn-danger" type="button"
                                                onclick="document.getElementById('del_order').submit()">删除订单
                                        </button>
                                    </a>
                                    <div style="display: none;">
                                        <form action="{{ route('order.success',$order->id) }}" method="post"
                                              id="success_order">
                                            <input type="text" name="order_id" value="{{ $order->id }}"/>
                                        </form>
                                        <form action="{{ route('order.destroy',$order->id) }}" method="post"
                                              id="del_order">
                                            @method('delete')
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(function () {
            $("#order_success").modal('show');
        })
    </script>
@endsection
