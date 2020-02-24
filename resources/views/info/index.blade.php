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
               @include('info._menu')
                <div class="card">
                    <div class="card-body">
                        物业电话:15971436290  社区电话:（027）61880180
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
