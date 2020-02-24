@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><a href="{{ route('admin.product',$mall->id) }}">商品管理</a> / 添加{{ $mall->name }}商品</div>
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{route('admin.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputPassword1">商品名称</label>
                                <input type="text" class="form-control" name="name" id="exampleInputPassword1" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2">商品金额</label>
                                <input type="text" class="form-control" id="exampleInputPassword2" name="money" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2">库存数量</label>
                                <input type="text" class="form-control" id="exampleInputPassword2" name="stock" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">商品描述</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="6" name="description"></textarea>
                            </div>
                            <input type="hidden" name="mall_id" value="{{ $mall->id }}">
                            <button type="submit" class="btn btn-primary">提交</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection