@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">编辑商品</div>
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{route('admin.update',$product->id)}}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="exampleInputPassword1">商品名称</label>
                                <input type="text" class="form-control" name="name" id="exampleInputPassword1" value="{{ $product->name }}"  required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">商品金额</label>
                                <input type="number" class="form-control" id="exampleInputPassword1" name="money" value="{{ $product->money }}" max="9999" min="1">
                            </div>
                            <button type="submit" class="btn btn-primary">提交</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection