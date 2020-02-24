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
                    <div class="card-header"><a href="{{ route('admin.index') }}">管理中心</a> / {{ $mall->name }}商品一览 / <a href="{{ route('admin.create',$mall_id) }}">添加商品</a></div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">商家名称</th>
                                <th scope="col">商品名称</th>
                                <th scope="col">套餐单价</th>
                                <th scope="col">商品描述</th>
                                <th scope="col">库存数量</th>
                                <th scope="col">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <th scope="row">{{ $product->id }}</th>
                                    <th scope="row">{{ $product->mall->name }}</th>
                                    <td>{{ $product->name }}</td>
                                    <td>￥{{ $product->money }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td><a href="{{ route('admin.edit',['mall_id'=>$mall->id,'id'=>$product->id]) }}">编辑</a> /
                                        <a href="javascript:;"
                                           onclick="document.getElementById('product_{{$product->id}}').submit()">删除</a>
                                        <div style="display: none;">
                                            <form action="{{ route('admin.destroy',$product->id) }}" method="post"
                                                  id="product_{{ $product->id }}">
                                                <input type="hidden" name="mall_id" value="{{ $mall->id }}">
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
                </div>
            </div>
        </div>
    </div>
@endsection