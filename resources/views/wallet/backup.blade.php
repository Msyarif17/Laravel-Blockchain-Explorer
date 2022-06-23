@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <img class="img-fluid rounded mx-auto d-block" width="200" height="200" src="data:image/png;base64,{{ DNS2D::getBarcodePNG($pk, 'QRCODE') }}" alt="barcode"   />
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Private Key</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" readonly rows="3">
                            {{$pk}}
                        </textarea>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
