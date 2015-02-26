@extends('layout/master')

@section('title', 'Keyring | Create record')

@section('page_top')
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h2>Create a new keyring record</h2>
        </div>
    </div>
</div>
</div>
@stop

@section('create_key')
<div class="col-md-3 col-md-offset-9">
    {{ HTML::link('/keyring', 'Back to my keys', array('class' => 'btn-lg btn-primary'))}}
</div>
@stop

@if(Session::has('master_key'))
@section('content')
<div class="col-md-6 top-buffer">

    @if(Session::has('form-errors'))
    <div class="alert alert-danger">
        {{Session::get('form-errors')}}
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div id="create_keyring">
        {{ Form::open(array('url' => '/keyring/store', 'method' => 'post', 'class' => 'form-horizontal')) }}
        <div class="form-group">
            {{ Form::label('keyring_host', 'Host', array('class' => 'col-sm-4 control-label')) }}
            <div class="col-sm-7">
                {{ Form::text('keyring_host', null, array('class' => 'form-control', 'placeholder'=>'http://www.example.com')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('keyring_username', 'Username', array('class' => 'col-sm-4 control-label')) }}
            <div class="col-sm-7">
                {{ Form::text('keyring_username', null, array('class' => 'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('keyring_password', 'Password', array('class' => 'col-sm-4 control-label')) }}
            <div class="col-sm-7">
                {{ Form::password('keyring_password', array('class' => 'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('keyring_password_confirmation', 'Confirm password', array('class' => 'col-sm-4 control-label')) }}
            <div class="col-sm-7">
                {{ Form::password('keyring_password_confirmation', array('class' => 'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-7">
                <div>
                    {{ Form::submit('Add to keyring', array('class' => 'btn btn-primary')) }}
                </div>

            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-7">
                <div>
                    {{ HTML::link('/keyring', 'Back to My keys', array('class' => 'btn btn-info'))}}
                </div>

            </div>
        </div>

        {{ Form::close() }}
    </div>
</div>
@stop
@endif
