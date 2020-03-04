@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><a href="{{ route('admin.index') }}">管理中心</a> / <a href="{{route('admin.aged.index')}}">特殊关爱群里管理</a> / 编辑特殊关爱群体</div>
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{route('admin.aged.update',$aged->id)}}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="exampleInputPassword1">姓名</label>
                                <input type="text" class="form-control" name="name" id="exampleInputPassword1" required value="{{ $aged->name }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2">手机号码</label>
                                <input type="text" class="form-control" id="exampleInputPassword2" name="tel" required maxlength="11" minlength="11" value="{{ $aged->tel }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword3">居住楼栋 例如:东区12栋1单元101</label>
                                <input type="text" class="form-control" id="exampleInputPassword3" name="address" required value="{{ $aged->address }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea4">紧急联系人及电话 例如:女儿 13939393931</label>
                                <input type="text" class="form-control" id="exampleInputPassword4" name="children_tel" value="{{ $aged->children_tel }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">备注</label>
                                <textarea id="exampleFormControlTextarea1" rows="5" name="note" class="form-control">{{ $aged->note }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">提交</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection