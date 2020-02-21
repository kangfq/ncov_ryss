@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-12" style="margin-top: 10px;">
                <div class="card">
                    <div class="card-header"><a href="{{ route('admin.index') }}">管理中心</a> / @if($mall_id==1) 麦德龙@else
                            中百@endif订单信息
                        <div style="display: inline-block;float: right;">
                            @if($state==1)
                                <button type="button" class="btn btn-sm btn-success" style="cursor: default;">当前状态：接单中</button>
                            @else
                                <button type="button" class="btn btn-sm btn-dark" style="cursor: default;">当前状态：休息中</button>
                            @endif
                            <button type="button" class="btn btn-sm btn-dark"
                                    onclick="document.getElementById('end').submit();">停止接单
                            </button>
                            <form action="{{route('admin.trigger',$mall_id) }}" id="end" style="display: none;"
                                  method="post">
                                <input type="text" name="state" value="0">
                            </form>
                            <button type="button" class="btn btn-sm btn-danger"
                                    onclick="document.getElementById('start').submit();">开始接单
                            </button>
                            <form action="{{route('admin.trigger',$mall_id) }}" id="start" style="display: none;"
                                  method="post">
                                <input type="text" name="state" value="1">
                            </form>
                        </div>
                    </div>
                    <div class="card-header">
                        <form action="" method="get">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputCity">下单日期</label>
                                    <input type="date" class="form-control" id="inputCity" name="created_at"
                                           value="{{ Request::input('created_at') }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputCity">收款日期</label>
                                    <input type="date" class="form-control" id="inputCity" name="pay_date"
                                           value="{{ Request::input('pay_date') }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">收款状态</label>
                                    <select id="inputState" class="form-control" name="pay_state">
                                        <option selected value="">--未指定--</option>
                                        <option value="y" @if(Request::input('pay_state')=='y') selected @endif>已收款
                                        </option>
                                        <option value="n" @if(Request::input('pay_state')=='n') selected @endif>未收款
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">收货状态</label>
                                    <select id="inputState" class="form-control" name="is_success">
                                        <option selected value="">--未指定--</option>
                                        <option value="y" @if(Request::input('is_success')=='y') selected @endif>已收货
                                        </option>
                                        <option value="n" @if(Request::input('is_success')=='n') selected @endif>未收货
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">筛选</button>
                            <a href="{{ route('admin.order') }}">
                                <button type="button" class="btn btn-primary">重置</button>
                            </a>
                            <button type="button" class="btn btn-danger" onclick="window.print();">打印本页</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">订单号</th>
                                <th scope="col">商家</th>
                                <th scope="col">下单日期</th>
                                <th scope="col">姓名</th>
                                <th scope="col">电话</th>
                                <th scope="col">商品详情</th>
                                <th scope="col">总件数</th>
                                <th scope="col">订单金额</th>
                                <th scope="col">收款时间</th>
                                <th scope="col">确认收货</th>
                                <th scope="col">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <th>{{ $order['id'] }}</th>
                                    <th>{{ $order['mall']->name }}</th>
                                    <th>{{ $order['created_at'] }}</th>
                                    <td>{{ $order['name'] }}</td>
                                    <td>{{ $order['tel']}}</td>
                                    <td>{{ $order['pro_text'] }}</td>
                                    <td>{{ $order['total_num'] }}</td>
                                    <td>￥{{ $order['total_money'] }}</td>
                                    <td>@if(is_null($order['pay_time']))
                                            <a href="javascript:;"
                                               onclick="document.getElementById('pay_{{$order['id']}}').submit()">
                                                <button type="button" class="btn btn-sm btn-danger">确认收款</button>
                                            </a>@else {{ $order['pay_time'] }} / <a href="javascript:;"
                                                                                    onclick="document.getElementById('pay_back_{{$order['id']}}').submit()">取消</a> @endif
                                    </td>
                                    <td>@if($order['is_success']===0) 未确认 @else 已确认  @endif</td>
                                    <td><a href="javascript:;" onclick="document.getElementById('del_order_{{$order['id']}}').submit()">删除</a>
                                        <form action="{{ route('order.destroy',$order['id']) }}" method="post"
                                              id="del_order_{{ $order['id'] }}">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </td>
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
                        <hr>
                        <b>【汇总信息】商品总件数：{{ $base['total_num'] }}件，订单总金额：{{ $base['total_money'] }}
                            元，已收款{{ $base['total_pay_money'] }}元，已收货{{ $base['success_y'] }}
                            单，未收货{{ $base['success_n'] }}单。（疫情期间，请各位志愿者注意身体！）^_^</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection