@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">公告！</h4>
            <p>本网站由小区志愿者创建，作为疫情期间帮助业主了解信息和购物的平台之一，无任何盈利目的。</p>
            <p>小区所有志愿者对接商超购物没有一分钱收入和其他利益，请大家多支持和理解，购物过程中主动配合相关工作。</p>
            <hr>
            <p class="mb-0">新冠病毒不容小视，请各位邻居千万重视，保护好自己和家人。</p>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <b>信息公开</b>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">最新信息</h5>
                        <p class="card-text">小区疫情信息和业主们可能需要的信息汇总。</p>
                        <a href="{{ route('info.index') }}" class="btn btn-primary">查看信息</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <b>在线购物</b>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">对接盘龙城麦德龙 / 天纵城中百</h5>
                        <p class="card-text">在系统下单后将由小区志愿者为您服务，感谢他们的付出！</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">进入系统</a>
                    </div>
                </div>
            </div>

        </div>
        <hr>
        *联系站长 QQ群：86019555（日月山水业主群）
    </div>
@endsection
