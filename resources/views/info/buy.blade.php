@extends('layouts.app')

@section('content')
    <link href="/vendor/common.css" rel="stylesheet">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><a href="/">首页</a> / <a href="{{route('info.index')}}">信息公开</a> / 购物信息
                    </div>
                    <div class="card-body">
                        <div class="card-title">
                            尊敬的各位邻居，目前除了在本站网上订购商超的商品外，以下商户也为小区提供服务，请自由选择。
                            <hr>
                        </div>
                        <div class="mall">
                            <div>
                                <p>东区友善超市日用品蔬菜</p>
                                <img src="/vendor/qrcode/youshan.png" style="width: 200px;">
                            </div>
                            <div>
                                <p>西区菜鸟驿站蔬菜</p>
                                <img src="/vendor/qrcode/cainiao.png" style="width: 200px;">
                            </div>
                            <div>
                                <p>日月山水 果蔬配送</p>
                                <img src="/vendor/qrcode/guoshu.png" style="width: 200px;">
                            </div>
                            <div>
                                <p>西区四季生鲜</p>
                                <img src="/vendor/qrcode/siji.png" style="width: 200px;">
                            </div>
                            <div>
                                <p>西区芙蓉兴盛超市</p>
                                <img src="/vendor/qrcode/furong.png" style="width: 200px;">
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
