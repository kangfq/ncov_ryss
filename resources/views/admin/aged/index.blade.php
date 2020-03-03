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
                    <div class="card-header"><a href="{{ route('admin.index') }}">管理中心</a> / 特殊关爱群体 / <a href="{{ route('admin.aged.create') }}">新建群体</a></div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">姓名</th>
                                <th scope="col">手机号</th>
                                <th scope="col">居住地址</th>
                                <th scope="col">紧急联系人及方式</th>
                                <th scope="col">备注</th>
                                <th scope="col">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ageds as $aged)
                                <tr>
                                    <th scope="row">{{ $aged->id}}</th>
                                    <th scope="row">{{ $aged->name}}</th>
                                    <th scope="row">{{ $aged->tel}}</th>
                                    <th scope="row">{{ $aged->address}}</th>
                                    <th scope="row">{{ $aged->children_tel}}</th>
                                    <th scope="row">{{ $aged->note}}</th>
                                    <th scope="row"><a href="javascript:;" onClick="document.getElementById('del_aged_{{ $aged->id }}').submit();">删除</a>
                                        <form action="{{ route('admin.aged.destroy',$aged->id) }}" method="post" id="del_aged_{{ $aged->id }}">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </th>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
            {{ $ageds->links() }}
    </div>
@endsection
