<?php
//Global params
//-------------
//Pattern match - '$id' can only be numeric
Route::pattern('id', '[0-9]+');

//Application routes
//------------------
//Account
//-------
//Account: create account
Route::get('/account/create_account', 'AccountController@createAccount');
//Account: store account
Route::post('/account/store_account', 'AccountController@storeAccount');
//Account: create master key
Route::get('/account/create_master_key', 'AccountController@createMasterKey')->before('auth|isMasterKeyAlreadySet');
//Account: store master key
Route::post('/account/store_master_key', 'AccountController@storeMasterKey')->before('auth|isMasterKeyAlreadySet');
//Account: login
Route::get('/account/login', 'AccountController@login');
Route::post('/account/login', 'AccountController@checkLogin');
//Account: logout
Route::get('/account/logout', 'AccountController@logout');

//Keyring application
//-------------------
//Keyring: display
Route::get('/keyring', 'KeyringController@show')->before('auth|createMasterKeyIfNeeded');
//Keyring: check master password
Route::post('/keyring', 'KeyringController@checkMasterKey')->before('auth');
//Keyring: relock all passwords with master key
Route::get('/keyring/relock_all_records', 'KeyringController@relockRecords')->before('auth');
//Keyring: relock one record
Route::get('/keyring/relock_this_record', 'KeyringController@relockRecord')->before('auth');

//Keyring: create keyring
Route::get('/keyring/create', 'KeyringController@create')->before('auth');
//Keyring: store keyring
Route::post('/keyring/store', 'KeyringController@store')->before('auth');

//Keyring: edit keyring
Route::get('/keyring/edit/{id}', 'KeyringController@edit')->before('auth|permission');
//Keyring: update keyring
Route::put('/keyring/update/{id}', 'KeyringController@update')->before('auth|permission');
//Keyring: delete keyring
Route::delete('/keyring/delete/{id}', 'KeyringController@destroy')->before('auth|permission');

//Other pages
//-----------
//Home page
Route::get('/', 'HomeController@showIndex');
