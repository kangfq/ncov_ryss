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
                                <button type="button" class="btn btn-sm btn-success" style="cursor: default;">当前状态：接单中
                                </button>
                            @else
                                <button type="button" class="btn btn-sm btn-dark" style="cursor: default;">当前状态：休息中
                                </button>
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
                            <button type="submit" class="btn btn-primary btn-sm">筛选</button>
                                <a href="{{ route('admin.order',$mall_id) }}">
                                    <button type="button" class="btn btn-primary btn-sm">重置</button>
                                </a>
                            <div style="float: right;">
                                <a href="{{ route('admin.recycle.index',$mall_id) }}"><button type="button" class="btn btn-sm btn-danger">订单回收站</button></a>
                                <a href="{{ route('order.export_order',['id'=>$mall_id,'created_at'=>Request::input('created_at'),'pay_date'=>Request::input('pay_date'),'pay_state'=>Request::input('pay_state'),'is_success'=>Request::input('is_success')]) }}">
                                    <button type="button" class="btn btn-danger btn-sm">导出到Excel</button>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" onclick="window.print();">打印本页
                                </button>
                                <a href="{{ route('admin.total_order',$mall_id) }}"><button type="button" class="btn btn-danger btn-sm">商超报表
                                </button></a>
                            </div>
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
                                <th scope="col">确认收款</th>
                                <th scope="col">确认收货</th>
                                <th scope="col">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr data-id="{{ $order->id }}">
                                    <th>{{ $order['id'] }}</th>
                                    <td>{{ $order['mall']->name }}</td>
                                    <td>{{ $order['created_at'] }}</td>
                                    <td>{{ $order['name'] }}</td>
                                    <td>{{ $order['tel']}}</td>
                                    <td>{{ $order['pro_text'] }}</td>
                                    <td>{{ $order['total_num'] }}</td>
                                    <td>￥{{ $order['total_money'] }}</td>
                                    <td>@if(is_null($order['pay_time']))
                                            <button type="button" class="btn btn-sm btn-danger pay">确认收款</button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-dark pay_back">取消收款</button>
                                        @endif
                                    </td>
                                    <td>@if($order['is_success']===0)
                                            <button class="btn btn-secondary btn-sm" disabled>否</button>@else
                                            <button class="btn btn-success btn-sm" disabled>是</button>  @endif</td>
                                    <td><a href="javascript:;"
                                           onclick="document.getElementById('del_order_{{$order['id']}}').submit()">删除</a>
                                        <form action="{{ route('order.destroy',$order['id']) }}" method="post"
                                              id="del_order_{{ $order['id'] }}">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="is_admin" value="1">
                                        </form>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                        {{ $orders->appends(['created_at' => Request::input('created_at'),'pay_date'=>Request::input('pay_date'),'pay_state'=>Request::input('pay_state'),'is_success'=>Request::input('is_success')])->links() }}
                        <hr>
                        <b>【汇总信息】订单数量：{{ $base['count'] }}，商品总件数：{{ $base['total_num'] }}
                            件，订单总金额：{{ $base['total_money'] }}
                            元，已收款{{ $base['total_pay_money'] }}元，已收货{{ $base['success_y'] }}
                            单，未收货{{ $base['success_n'] }}单。（疫情期间，请各位志愿者注意身体！）^_^</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(function () {
            //确认收款
            $(document).on("click", ".pay", function () {
                let id = $(this).parents("tr").data("id");
                let _this = $(this);
                $.ajax({
                    type: 'post',
                    data: {id: id},
                    url: "{{ route('admin.pay') }}",
                    success: function (e) {
                        if (e.state == 1) {
                            alert(e.msg);
                            _this.addClass("btn-dark").addClass("pay_back").removeClass("btn-danger").removeClass("pay");
                            _this.text("取消收款")
                        }
                    },
                    error: function (e) {
                        alert('系统错误,操作失败..')
                    }
                })
            });
            // 取消收款
            $(document).on("click", ".pay_back", function () {
                let id = $(this).parents("tr").data("id");
                let _this = $(this);
                $.ajax({
                    type: 'post',
                    data: {id: id},
                    url: "{{ route('admin.pay_back') }}",
                    success: function (e) {
                        if (e.state == 1) {
                            alert(e.msg);
                            _this.removeClass("btn-dark").removeClass("pay_back").addClass("btn-danger").addClass("pay");
                            _this.text("确认收款")
                        }
                    },
                    error: function (e) {
                        alert('系统错误,操作失败..')
                    }
                })
            });
        })
    </script>
@endsection