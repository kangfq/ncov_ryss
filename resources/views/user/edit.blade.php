@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><a href="{{ route('admin.user.index') }}">用户编辑</a></div>
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{route('admin.user.update',$user->id)}}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="exampleInputPassword1">用户名</label>
                                <input type="text" class="form-control" id="exampleInputPassword1" name="name" value="{{ $user->name }}" disabled >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2">管理权限</label>
                                <input type="text" class="form-control" id="exampleInputPassword2" name="is_admin" value="{{ $user->is_admin }}">
                            </div>
                            <button type="submit" class="btn btn-primary" >提交</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection