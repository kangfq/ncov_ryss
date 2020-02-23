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
                    <div class="card-header"><a href="{{ route('admin.index') }}">管理中心</a> / <a href="{{ route('admin.order',$mall_id)  }}">订单管理</a> / {{ $mall_name }}商超报表
                    </div>
                    <div class="card-header">
                        <form action="" method="get">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputCity">收款开始日期</label>
                                    <input type="date" class="form-control" id="inputCity" name="start_date" required
                                           value="{{ Request::input('start_date') }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputCity">收款结束日期</label>
                                    <input type="date" class="form-control" id="inputCity" name="end_date" required
                                           value="{{ Request::input('end_date') }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">筛选</button>
                            <a href="{{ route('admin.total_order',$mall_id) }}"><button type="button" class="btn btn-primary btn-sm">重置</button></a>
                            <div style="float: right;">
                                <button type="button" class="btn btn-danger btn-sm" onclick="window.print();">打印本页
                                </button>
                            </div>
                        </form>
                        <hr>
                        <p>*没筛选日期的情况下默认显示今日的报表。</p>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">商品ID</th>
                                <th scope="col">商品名称</th>
                                <th scope="col">单价</th>
                                <th scope="col">数量</th>
                                <th scope="col">金额</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($final_products as $final_product)
                                <tr>
                                    <td>{{$final_product['product_id']}}</td>
                                    <td>{{$final_product['product_name']}}</td>
                                    <td>￥{{$final_product['product_price']}}</td>
                                    <td>{{$final_product['product_num']}}</td>
                                    <td>￥{{sprintf("%.2f",$final_product['product_num'] * $final_product['product_price'])}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th scope="row">合计</th>
                                <td colspan="2"></td>
                                <th>{{ $products_total_num }}</th>
                                <th>￥{{ sprintf("%.2f",$products_total_money) }}</th>
                            </tr>
                            </tbody>
                        </table>
                        {{--                        {{ $orders->appends(['created_at' => Request::input('created_at'),'pay_date'=>Request::input('pay_date'),'pay_state'=>Request::input('pay_state'),'is_success'=>Request::input('is_success')])->links() }}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
