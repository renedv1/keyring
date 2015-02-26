@extends('layout/master')

@section('title', 'Keyring | New account registration')

@section('page_top')
<div class="page-header">
    <div class="row">
        <div class="col-md-12">
            <h2>Create a new account</h2>
        </div>
    </div>
</div>
@stop


@section('content')
<div class="row">
    <div class="col-md-4">
        {{ Form::open(array('url'=>'account/store_account', 'class'=>'')) }}
        @if($errors->has())
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif

        <div class="form-group">
            <label class="sr-only" for="registerFirstName">First name</label>
            {{ Form::text('first_name', null, array('class'=>'form-control', 'id'=>'registerFirstName', 'placeholder'=>'First Name')) }}
        </div>

        <div class="form-group">
            <label class="sr-only" for="registerLastName">Last name</label>
            {{ Form::text('last_name', null, array('class'=>'form-control', 'id'=>'registerLastName', 'placeholder'=>'Last Name')) }}
        </div>

        <div class="form-group">
            <label class="sr-only" for="registerEmail">Email address</label>
            {{ Form::text('email', null, array('class'=>'form-control', 'id'=>'registerEmail', 'placeholder'=>'Email Address')) }}
        </div>

        <div class="form-group">
            <label class="sr-only" for="registerPassword">Login password</label>
            {{ Form::password('password', array('class'=>'form-control', 'id'=>'registerPassword', 'placeholder'=>'Login password')) }}
        </div>

        <div class="form-group">
            <label class="sr-only" for="registerPasswordConfirm">Confirm password</label>
            {{ Form::password('password_confirmation', array('class'=>'form-control', 'id'=>'registerPasswordConfirm', 'placeholder'=>'Confirm login password')) }}
        </div>

        {{ Form::submit('Register', array('class'=>'btn btn-large btn-primary btn-block'))}}
        {{ Form::close() }}
    </div>
</div>
@stop