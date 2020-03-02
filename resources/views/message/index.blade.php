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
                    <div class="card-header"><a href="{{ route('admin.index') }}">管理中心</a> / 建议&留言</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">用户名</th>
                                <th scope="col">留言内容</th>
                                <th scope="col">留言日期</th>
                                <th scope="col">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($messages as $message)
                                <tr>
                                    <th scope="row">{{ $message->id }}</th>
                                    <th scope="row">{{ $message->user->name }}</th>
                                    <td>{{ $message->content }}</td>
                                    <td>{{ $message->created_at }}</td>
                                    <td><a href="javascript:;" onclick="document.getElementById('del_message_{{ $message->id }}').submit();">删除</a>
                                        <form action="{{ route('message.destroy',$message->id) }}" style="display:none;" id="del_message_{{ $message->id }}" method="post">
                                            @csrf
                                            @method('delete')
                                        </form>
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