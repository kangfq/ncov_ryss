@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row justify-content-center">
            @foreach($malls as $mall)
                <div class="col-md-6">
                    <div class="list-group">
                        <button type="button" disabled class="list-group-item list-group-item-action active">
                            {{ $mall->name }}后台管理
                        </button>
                        <a href="{{ route('admin.product',$mall->id) }}">
                            <button type="button" class="list-group-item list-group-item-action">商品管理[{{ $mall->name }}]</button>
                        </a>
                        <a href="{{ route('admin.order',$mall->id) }}">
                            <button type="button" class="list-group-item list-group-item-action">订单管理[{{ $mall->name }}]</button>
                        </a>
                    </div>
                </div>
            @endforeach


            <hr>
        </div>
    </div>
@endsection