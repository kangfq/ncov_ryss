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
                    <div class="card-header">商品一览 / <a href="{{ route('admin.create') }}">添加商品</a></div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">套餐名称</th>
                                <th scope="col">套餐单价</th>
                                <th scope="col">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <th scope="row">{{ $product->id }}</th>
                                    <td>{{ $product->name }}</td>
                                    <td>￥{{ $product->money }}</td>
                                    <td><a href="{{ route('admin.edit',$product->id) }}">编辑</a> /
                                        <a href="javascript:;"
                                           onclick="document.getElementById('product_{{$product->id}}').submit()">删除</a>
                                    </td>
                                </tr>
                                <div style="display: none;">
                                    <form action="{{ route('admin.destroy',$product->id) }}" method="post"
                                          id="product_{{ $product->id }}">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <hr>
            <div class="col-md-12" style="margin-top: 10px;">
                <div class="card">
                    <div class="card-header">订单信息</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">订单号</th>
                                <th scope="col">下单日期</th>
                                <th scope="col">姓名</th>
                                <th scope="col">电话</th>
                                <th scope="col">商品详情</th>
                                <th scope="col">总件数</th>
                                <th scope="col">订单金额</th>
                                <th scope="col">付款时间</th>
                                <th scope="col">确认收货</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <th>{{ $order['id'] }}</th>
                                    <th>{{ $order['created_at'] }}</th>
                                    <td>{{ $order['name'] }}</td>
                                    <td>{{ $order['tel']}}</td>
                                    <td>{{ $order['pro_text'] }}</td>
                                    <td>{{ $order['total_num'] }}</td>
                                    <td>￥{{ $order['total_money'] }}</td>
                                    <td>@if(is_null($order['pay_time']))
                                            <a href="javascript:;" onclick="document.getElementById('pay_{{$order['id']}}').submit()">
                                                <button type="button" class="btn btn-sm btn-danger">确认付款</button>
                                            </a>@else {{ $order['pay_time'] }} / <a href="javascript:;" onclick="document.getElementById('pay_back_{{$order['id']}}').submit()">取消</a> @endif</td>

                                    <td>@if($order['is_success']===0) 未确认 @else 已确认  @endif</td>
                                </tr>
                                <div style="display: none;">
                                    <form action="{{ route('admin.pay',$order['id']) }}" method="post"
                                          id="pay_{{ $order['id'] }}">
                                        @csrf
                                    </form>
                                    <form action="{{ route('admin.pay_back',$order['id']) }}" method="post"
                                          id="pay_back_{{ $order['id'] }}">
                                        @csrf
                                    </form>
                                </div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection