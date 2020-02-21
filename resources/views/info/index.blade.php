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
                    <div class="card-header"><a href="{{ route('home') }}">个人中心</a> / 信息公开</div>
                    <div class="card-body">
                        物业电话:111111 社区电话:111111
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
