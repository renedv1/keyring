@extends('layout/master')

@section('title', 'Keyring | Create a Master Key')

@section('page_header_text')
<h2>Master Key setup</h2>
@stop


@section('content')
{{ Form::open(array('url'=>'account/store_master_key', 'class'=>'form-signup')) }}
{{ Form::hidden('account_id', Session::get('account_id')) }}

<h2 class="form-signup-heading">Create a Master Key</h2>

<div class="form-group">
    The Master Key enables you unlock, reveal and relock all the passwords on your keyring.
</div>

<div class="form-group text-danger">
    Please note that this is the ONLY time you can set your Master Key.  Once set, it cannot be reset!
</div>

@if($errors->has())
<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
@endif



<div class="form-group">
    <label class="sr-only" for="createMasterKey">Master key</label>
    {{ Form::password('master_key', array(
                'class'=>'form-control', 
                'id'=>'createMasterKey', 
                'autocomplete'=>'off', 
                'placeholder'=>'Enter a master key')) }}
</div>

<div class="form-group">
    <label class="sr-only" for="createMasterKeyConfirm">Email address</label>
    {{ Form::password('master_key_confirmation', array(
                'class'=>'form-control', 
                'id'=>'createMasterKeyConfirm', 
                'autocomplete'=>'off', 
                'placeholder'=>'Confirm your master key')) }}
</div>

<div class="form-group">
    <label class="form-inline" for="createMasterKeySendEmail">Email master key to {{Session::get('email')}}</label>
    {{ Form::checkbox('master_key_send_email', 'true', true); }} (recommended)
</div>

{{ Form::submit('Create Master Key', array('class'=>'btn btn-large btn-primary btn-block'))}}
{{ Form::close() }}
@stop