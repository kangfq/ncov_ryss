@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><a href="{{ route('home') }}">个人中心</a> / 我的订单</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">订单号</th>
                                <th scope="col">姓名</th>
                                <th scope="col">手机号码</th>
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
                            @foreach($orders as $order)
                                <tr>
                                    <th scope="row">{{ $order['id'] }}</th>
                                    <th scope="row">{{ $order['name'] }}</th>
                                    <th scope="row">{{ $order['tel'] }}</th>
                                    <th scope="row">{{ $order['created_at'] }}</th>
                                    <td>{{  $order['pro_text'] }}</td>
                                    <td>￥{{ $order['total_money'] }}</td>
                                    <td>{{ $order['total_num'] }}</td>
                                    <td>{{ $order['pay_time'] }}</td>
                                    <td>@if($order['is_success']===0) <a href="javascript:;">
                                            <div style="display: none;">
                                                <form action="{{ route('order.success') }}" method="post" id="success_{{ $order['is_success'] }}">
                                                    @csrf
                                                    <input type="text" name="order_id" value="{{ $order['id'] }}">
                                                </form>
                                            </div>
                                            <button class="btn btn-sm btn-danger" onclick="document.getElementById('success_{{$order['is_success']}}').submit()">确认收货</button></a> @else 已收货 @endif</td>
                                    <td><a href="{{ route('order.show',$order['id'])}}">查看详情</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
