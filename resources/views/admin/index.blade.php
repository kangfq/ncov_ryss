@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{ route('admin.product') }}"><button type="button" class="btn btn-primary">商品管理</button></a>
                <a href="{{ route('admin.order') }}"><button type="button" class="btn btn-primary">订单管理[麦德龙]</button></a>
                <a href="{{ route('admin.zborder') }}"><button type="button" class="btn btn-primary">订单管理[中百]</button></a>
            </div>

            <hr>
        </div>
    </div>
@endsection