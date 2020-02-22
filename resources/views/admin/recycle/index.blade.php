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
                    <div class="card-header"><a href="{{ route('admin.index') }}">管理中心</a> / @if($mall_id==1)<a href="{{route('admin.order',$mall_id)}}">订单管理</a>@endif @if($mall_id==2)<a href="{{route('admin.zborder')}}">订单管理</a>@endif / {{ $mall_name }}订单回收站</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">订单号</th>
                                <th scope="col">商家</th>
                                <th scope="col">下单时间</th>
                                <th scope="col">姓名</th>
                                <th scope="col">手机号码</th>
                                <th scope="col">商品</th>
                                <th scope="col">订单金额</th>
                                <th scope="col">删除时间</th>
                                <th scope="col">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->mall->name }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->tel }}</td>
                                    <td>{{ $order->pro_text }}</td>
                                    <td>{{ $order->total_money }}</td>
                                    <td>{{ $order->deleted_at }}</td>
                                    <td><a href="javascript:;" onclick="document.getElementById('back_order_{{$order->id}}').submit()">恢复</a>
                                        <form action="{{ route('admin.recycle.back_order') }}" method="post" id="back_order_{{$order->id}}">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        </form>
                                    </td>

                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
