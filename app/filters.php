<?php

/*
  |--------------------------------------------------------------------------
  | Application & Route Filters
  |--------------------------------------------------------------------------
  |
  | Below you will find the "before" and "after" events for the application
  | which may be used to do any work before or after a request into your
  | application. Here you may also register your custom route filters.
  |
 */

App::before(function($request) {
//
});


App::after(function($request, $response) {
//
});


/**
 * Redirects the user to their 'keyring' page if their master key is already set
 */
Route::filter('isMasterKeyAlreadySet', function() {
    if (Account::isMasterKeySet()) {
        return Redirect::to('/keyring')->with('alert-danger', 'You have already set a master key');
    } 
});

/**
 * Forces user to create a master key if one is not yet set
 */
Route::filter('createMasterKeyIfNeeded', function() {
    if (!Account::isMasterKeySet()) {
        return Redirect::to('/account/create_master_key');
    } 
});

/**
 * Check if the user is the owner of this resource
 */  
Route::filter('permission', function() {
    //get the resource (keyring) id
    $id = Route::input('id');
    
    //get the current user's id
    $account = Auth::getUser();
    
    //generate an 'Illuminate\Database\Eloquent\Collection Object'
    $keyring = Keyring::where('id', '=', $id)->where('account_id', '=', $account->id)->get();
    
    //if the result is empty, the user does not own this resource
    if ($keyring->isEmpty()) {
        return Redirect::to('/keyring')->with('alert-danger', 'Permission denied: you do not have the correct privileges to access that resource');
    }
});


/*
  |--------------------------------------------------------------------------
  | Authentication Filters
  |--------------------------------------------------------------------------
  |
  | The following filters are used to verify that the user of the current
  | session is logged into this application. The "basic" filter easily
  | integrates HTTP Basic authentication for quick, simple checking.
  |
 */

Route::filter('auth', function() {
    if (Auth::guest()) {
        if (Request::ajax()) {
            return Response::make('Unauthorized', 401);
        } else {
            return Redirect::guest('account/login');
        }
    }
});


Route::filter('auth.basic', function() {
    return Auth::basic();
});

/*
  |--------------------------------------------------------------------------
  | Guest Filter
  |--------------------------------------------------------------------------
  |
  | The "guest" filter is the counterpart of the authentication filters as
  | it simply checks that the current user is not logged in. A redirect
  | response will be issued if they are, which you may freely change.
  |
 */

Route::filter('guest', function() {
    if (Auth::check())
        return Redirect::to('/');
});

/*
  |--------------------------------------------------------------------------
  | CSRF Protection Filter
  |--------------------------------------------------------------------------
  |
  | The CSRF filter is responsible for protecting your application against
  | cross-site request forgery attacks. If this special token in a user
  | session does not match the one given in this request, we'll bail.
  |
 */

Route::filter('csrf', function() {
    if (Session::token() !== Input::get('_token')) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});
