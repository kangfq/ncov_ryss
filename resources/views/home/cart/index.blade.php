@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif



        @if($mall->is_show==0)
            <div class="alert alert-danger" role="alert">
                {{ $mall->name }}暂时未开放订菜，请留意群内通知！
            </div>
        @endif
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">首页</a></li>
                <li class="breadcrumb-item"><a href="{{ route('home') }}">个人中心</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $mall->name }}购物车</li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th scope="col">序号</th>
                                <th scope="col">商品</th>
                                <th scope="col">单价</th>
                                <th scope="col">数量</th>
                                <th scope="col">总金额</th>
                                <th scope="col">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($carts as $cart)
                                <tr>
                                    <th scope="row">{{ $cart->id }}</th>
                                    @if(!is_null($cart->product))
                                        <td>{{ $cart->product->name  }}</td>
                                        <td>￥{{  $cart->product->money }}</td>
                                        <td>{{ $cart->total_num }}</td>
                                        <td>￥{{ $cart->total_num * $cart->product->money }}</td>
                                    @else
                                        <td>无效商品</td>
                                        <td>无效商品</td>
                                        <td>{{ $cart->total_num }}</td>
                                        <td>无效商品</td>
                                    @endif

                                    <td><a href="javascript:;"
                                           onclick="document.getElementById('del_{{ $cart->id}}').submit()">删除</a>
                                        <div style="display: none">
                                            <form action="{{ route('cart.destroy',$cart->id) }}" method="post"
                                                  id="del_{{ $cart->id }}">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-header">合计金额：￥{{ $total_price }}</div>
                    <div class="card-header">
                        <a href="{{ route('order.create',$mall->id) }}">
                            <button type="button" class="btn btn-primary">继续购物</button>
                        </a>
                        @if($mall->is_show==0)
                            <button type="submit" class="btn btn-warning" disabled>商家休息中</button>
                        @endif
                        @if($mall->is_show==1)
                            <button type="submit" class="btn btn-danger" data-toggle="modal"
                                    data-target="#staticBackdrop">提交订单
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">重要提示</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>1、此团购服务仅为本小区在住业主服务，不允许帮其他小区业主购买。（菜品每个社区都是限量供应）</p>
                    <p>2、部分商品缺货商超会自动替换等值商品，恕不另行通知。</p>
                    <p>*违背第1条我们会冻结你的账户，拒绝为你提供服务。</p>
                    <p>*如果你同意以上约定，请点击【我同意】，否则请点击【我不同意】退出购物。</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">我不同意</button>
                    <form action="{{ route('order.store') }}" method="post">
                        @csrf
                        <input type="hidden" value="{{ $mall->id }}" name="mall_id">
                        @if($mall->is_show==1)
                            <button type="submit" class="btn btn-primary">我同意</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

