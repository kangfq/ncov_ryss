@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">收货信息</div>
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card-body">
                        @if(!is_null($address))
                            <div>
                                <p>您的收货信息已经提交,不需要重复提交!</p>
                                <p>您的姓名: {{ $address->name }} 您的电话: {{ $address->tel }}</p>
                                <p><a href="{{route('home')}}">返回</a></p>
                            </div>
                        @else
                            <form action="{{route('address.store')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputPassword1">姓名</label>
                                    <input type="text" class="form-control" name="name" id="exampleInputPassword1" required>
                                    <small id="emailHelp" class="form-text text-muted">请输入自己的真实姓名</small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">手机号码</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" name="tel" required>
                                    <small id="emailHelp" class="form-text text-muted">请输入自己的手机号码</small>
                                </div>
                                <div class="form-text text-muted" style="color: red!important;">请注意此信息只能输入一次,请务必准确</div>
                                <button type="submit" class="btn btn-primary">提交</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
