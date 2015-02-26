@extends('layout/master')

@section('title', 'Keyring | My Keys')

@section('page_top')
<div class="page-header">
    <div class="row">
        <div class="col-md-3">
            <h2>My keys</h2>
        </div>
        @if(Session::has('master_key'))
        <div class="col-md-3 col-md-offset-6">
            {{ HTML::link('/keyring/create', 'Create', array('class' => 'btn btn-success'))}}
            {{ HTML::link('/keyring/relock_all_records', 'Relock all records', array('class' => 'btn btn-danger'))}}
        </div>
        @else
        {{ Form::open(array('url' => '/keyring', 'method' => 'post')) }}
        <div class="col-md-4 col-md-offset-2">
            {{ Form::password('master_key',  array('class' => 'form-control', 'placeholder'=>'enter master key to create a new record', 'autocomplete'=>'off')) }}
        </div>
        <div class="col-md-1">
            {{ Form::submit('Create', array('class' => 'btn btn-success')) }}
        </div>
        {{ Form::close() }}
        @endif
    </div>
</div>
</div>
@stop


@section('content')
<div class="row">
    <div class="col-md-3"><h4>Host</h4></div>
    <div class="col-md-2"><h4>Username</h4></div>
    <div class="col-md-7"><h4>Password</h4></div>
</div>

@foreach($keyrings as $result)
@if(($master_key) && ($result->id == $keyring_id))
<div class="row resultSet addBg">
    <div class="col-md-3">{{ $result->keyring_host }}</div>
    <div class="col-md-2">{{ $result->keyring_username }}</div>
    <div class="col-md-4">
        {{ Helpers::decryptString(array('string' => $result->keyring_password, 'master_key' => $master_key)) }}
    </div>
    <div class="col-md-1">
        {{ HTML::link('/keyring/relock_this_record', 'Relock', array('class' => 'btn btn-danger'))}}
    </div>
    <div class="col-md-1">
        {{ HTML::link('/keyring/edit/' . $result->id, 'Edit', array('class' => 'btn btn-warning'))}}
    </div>
</div>
@elseif($master_key)
<div class="row resultSet">
    <div class="col-md-3">{{ $result->keyring_host }}</div>
    <div class="col-md-2">{{ $result->keyring_username }}</div>
    <div class="col-md-4 text-muted">
        {{ Form::open(array('url' => '/keyring', 'method' => 'post')) }}
        {{ Form::hidden('keyring_id',  $result->id) }}
        Click 'Unlock' to reveal this password
    </div>
    <div class="col-md-1">
        {{ Form::submit('Unlock', array('class' => 'btn btn-primary')) }}
        {{ Form::close() }}
    </div>
    <div class="col-md-1">
        {{ HTML::link('/keyring/edit/' . $result->id, 'Edit', array('class' => 'btn btn-warning'))}}
    </div>
</div>
@else 
<div class="row resultSet">
    <div class="col-md-3">{{ $result->keyring_host }}</div>
    <div class="col-md-2">{{ $result->keyring_username }}</div>
    {{ Form::open(array('url' => '/keyring', 'method' => 'post')) }}
    {{ Form::hidden('keyring_id',  $result->id) }}
    <div class="col-md-4">
        @if((Session::has('alert-warning')) && (Session::has('keyring_id') && (Session::get('keyring_id') == $result->id)))
        {{ Form::password('master_key',  array(
                    'class' => 'form-control', 
                    'id' => 'keyring_' . $result->id,
                    'placeholder'=>'enter master key to show password', 
                    'autocomplete'=>'off',
                    'data-toggle'=>'popover',
                    'data-placement'=>'bottom',
                    'data-content'=>Session::get('alert-warning'))) }}
        @else
        {{ Form::password('master_key',  array(
                    'class' => 'form-control', 
                    'id' => 'keyring_' . $result->id,
                    'placeholder'=>'enter master key to show password',
                    'autocomplete'=>'off')) }}
        @endif
    </div>
    <div class="col-md-1">
        {{ Form::submit('Unlock', array('class' => 'btn btn-primary')) }}
    </div>
    <div class="col-md-1">
        {{ Form::button('Edit', array('class' => 'btn btn-default disabled')) }}
    </div>
    {{ Form::close() }}
</div>
@endif
@endforeach
@stop

