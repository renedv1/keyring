@extends('layout/master')

@section('title', 'Keyring | Login')

@section('page_top')
<div class="page-header">
    <div class="row">
        <div class="col-md-12">
            <h2>Account login</h2>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="row top-buffer">
    <div class="col-md-4">
        {{ Form::open(array('url'=>'account/login', 'class'=>'')) }}

        <div class="form-group">
            <label class="sr-only" for="loginEmail">Email address</label>
            {{ Form::text('email', null, array('class'=>'form-control', 'id'=>'loginEmail', 'placeholder'=>'Email Address')) }}
        </div>

        <div class="form-group">
            <label class="sr-only" for="loginPassword">Password</label>
            {{ Form::password('password', array('class'=>'form-control', 'id'=>'loginPassword', 'placeholder'=>'Password')) }}
        </div>


        {{-- Form::text('email', null, array('class'=>'input-block-level', 'placeholder'=>'Email Address')) --}}
        {{-- Form::password('password', array('class'=>'input-block-level', 'placeholder'=>'Password')) --}}

        {{ Form::submit('Login', array('class'=>'btn btn-large btn-primary btn-block'))}}

        {{ Form::close() }}

    </div>
</div>

<div class="row top-buffer">
    <div class="col-md-4">
        <div class="form-group">
            Don't have an account yet? {{HTML::link('/account/create_account', 'Create an account')}}.
        </div>
    </div>
</div>
@stop