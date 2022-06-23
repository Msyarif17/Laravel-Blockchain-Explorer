@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Kirim Uang') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    {!! Form::open(['route' => 'wallet.create.transaction', 'method' => 'post', 'autocomplete' => 'false','enctype'=>'multipart/form-data']) !!}
                    <div class="row">
                        
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                {!! Form::label('to', 'Address') !!}
                                {!! Form::text('to', '', $errors->has('to') ? ['class' => 'form-control is-invalid'] : ['class' => 'form-control']) !!}
                                {!! $errors->first('to', '<p class="help-block invalid-feedback">:message</p>') !!}
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                {!! Form::label('amount', 'Amount') !!}
                                {!! Form::text('amount', '', $errors->has('amount') ? ['class' => 'form-control is-invalid'] : ['class' => 'form-control']) !!}
                                {!! $errors->first('amount', '<p class="help-block invalid-feedback">:message</p>') !!}
                            </div>
                        </div>
                            
                    </div>
                    <div class="box-footer mt-3">
                        {!! Form::submit('Send', ['class' => 'btn btn-primary btn-block', 'id' => 'save']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
