@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-item-center">
                    <div>
                        {{ __('Dashboard') }}
                    </div>
                    <div>
                        <a href="{{route('send')}}" class="btn btn-primary">Send</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p class="">Address         :{{$address}}</p>
                    <p class="">Balance         :{{$balance}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
