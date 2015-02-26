@extends('layout/master')

@section('title', 'Keyring | Edit record')

@section('page_top')
<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h2>Edit keyring record</h2>
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

    @foreach($keyring as $result)
    <div id="edit_keyring">

        {{ Form::open(array('url' => '/keyring/update/' . $result->id, 'method' => 'put', 'class' => 'form-horizontal')) }}
        <div class="form-group">
            {{ Form::label('keyring_host', 'Host', array('class' => 'col-sm-4 control-label')) }}
            <div class="col-sm-7">
                {{ Form::text('keyring_host', $result->keyring_host, array('class' => 'form-control', 'placeholder'=>'http://www.example.com')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('keyring_username', 'Username', array('class' => 'col-sm-4 control-label')) }}
            <div class="col-sm-7">
                {{ Form::text('keyring_username', $result->keyring_username, array('class' => 'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('keyring_existing_password', 'Current password', array('class' => 'col-sm-4 control-label')) }}
            <div class="col-sm-7 text-muted addFormPadding">
                {{ Helpers::decryptString(array('string' => $result->keyring_password, 'master_key' => $master_key)) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('keyring_password', 'New password', array('class' => 'col-sm-4 control-label')) }}
            <div class="col-sm-7">
                {{ Form::password('keyring_password', array(
                                    'class' => 'form-control', 
                                    'placeholder'=>'replaces the current password', 
                                    'autocomplete'=>'off')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('keyring_password_confirmation', 'Confirm new password', array('class' => 'col-sm-4 control-label')) }}
            <div class="col-sm-7">
                {{ Form::password('keyring_password_confirmation', array(
                                    'class' => 'form-control', 
                                    'placeholder'=>'confirm replacement password', 
                                    'autocomplete'=>'off')) }}
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-7">
                <div>
                    {{ Form::submit('Update record', array('class' => 'btn btn-primary')) }}
                </div>
            </div>
        </div>
        {{ Form::close() }}

        {{ Form::open(array('url' => '/keyring/delete/' . $result->id, 'method' => 'delete', 'class' => 'form-horizontal')) }}
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-7">
                <div>
                    {{ Form::button('Delete record', array(
                                        'class' => 'btn btn-danger',
                                        'type' => 'button',
                                        'data-toggle' => 'modal',
                                        'data-target' => '#confirmDelete',
                                        'data-title' => 'Delete record',
                                        'data-message' => 'Are you sure you want to delete this record?'
                                        )) }}
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-7">
                <div>
                    {{ HTML::link('/keyring', 'Back to My Keys', array('class' => 'btn btn-info'))}}
                </div>
            </div>
        </div>
        {{ Form::close() }}


    </div>
    @endforeach


    <!-- Modal Dialog -->
    <div class="modal" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirm">Delete</button>
                </div>
            </div>
        </div>
    </div>



    @stop
    @endif
