<?php

class AccountController extends \BaseController {

    protected $layout = 'layout.master';

    public function __construct() {
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    /*
      |--------------------------------------------------------------------------
      | Account login / logout
      |--------------------------------------------------------------------------
     */

    public function login() {
        $this->layout->content = View::make('account.login');
    }

    public function checkLogin() {
        if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')))) {
            Session::put('email', Input::get('email'));
            Session::put('account_id', Auth::id());
            return Redirect::to('/keyring');
        } else {
            return Redirect::to('account/login')
                            ->with('alert-warning', 'Your username/password combination was incorrect')
                            ->withInput();
        }
    }

    public function logout() {
        Auth::logout();
        Session::flush();
        return Redirect::to('/');
    }

    /*
      |--------------------------------------------------------------------------
      | Master key creation
      |--------------------------------------------------------------------------
     */

    /**
     * Show the form for creating a new master key.
     *
     * @return Response
     */
    public function createMasterKey() {
        $this->layout->content = View::make('account.create_master_key');
    }

    /**
     * Store the newly created master key in storage.
     *
     * @return Response
     */
    public function storeMasterKey() {
        $validator = Validator::make(Input::all(), Account::$storeMasterKeyRules);

        //validate form post
        if ($validator->passes()) {
            //validation pass
            //get account details
            $account = Account::find(Input::get('account_id'));
            //save: update keyring record in DB
            try {
                $account->master_key = Helpers::encryptString(array('string' => Input::get('master_key'), 'master_key' => Input::get('master_key')));
                $account->save();
            } catch (Exception $ex) {
                //error: record was not updated - display error messages 
                return Redirect::to('/account/create_master_key')->with('alert-warning', 'There was an error updating that record:')->withErrors('MySQL error: ' . $ex->getCode())->withInput();
            }

            //new master key was successfully saved 
            //add master key to the session
            Session::put('master_key', Input::get('master_key'));
            
            //email the user their master key (if checked in the form)
            if (Input::get('master_key_send_email')) {
                Mail::send('emails.master_key', array('master_key' => Input::get('master_key')), function($message) use ($account) {
                    $message->to($account->email, $account->first_name)->subject('Master Key reminder');
                });
            }
            
            //redirect user to the 'create new key' page
            return Redirect::to('/keyring/create')->with('alert-success', 'Master Key successfully set. Now please create a new record.');
        } else {
            // validation error: display error messages 
            return Redirect::to('/account/create_master_key')->with('alert-warning', 'The following errors occurred:')->withErrors($validator)->withInput();
        }
    }

    /*
      |--------------------------------------------------------------------------
      | New account registration
      |--------------------------------------------------------------------------
     */

    /**
     * Show the form for creating a new account.
     *
     * @return Response
     */
    public function createAccount() {
        $this->layout->content = View::make('account.create_account');
    }

    /**
     * Store the newly created account in storage.
     *
     * @return Response
     */
    public function storeAccount() {
        $validator = Validator::make(Input::all(), Account::$storeAccountRules);

        if ($validator->passes()) {
            // validation has passed
            // save user in DB
            $account = new Account;
            $account->first_name = Input::get('first_name');
            $account->last_name = Input::get('last_name');
            $account->email = Input::get('email');
            $account->password = Hash::make(Input::get('password'));
            $account->save();

            //automatically authenticate and 'log in' the new user
            if (Auth::attempt(array('email' => $account->email, 'password' => Input::get('password')))) {
                //set 'logged in cookies
                Session::put('email', $account->email);
                Session::put('account_id', $account->id);
                //redirect to main application page 
                //new users will be diverted once to 'create a master key'
                return Redirect::to('/keyring')->with('alert-success', 'Registration successful: now you need to create a Master Key');
            }

            //if automatic login fails, default to redirecting new user to the home page
            return Redirect::to('/')->with('alert-success', 'Registration successful: please log in');
        } else {
            // validation has failed
            // display error messages 
            return Redirect::to('account/create_account')->with('alert-danger', 'Please correct these errors')->withErrors($validator)->withInput();
        }
    }

    /*
      |--------------------------------------------------------------------------
      | Generic method stubs (php artisan controller:make AccountController)
      |--------------------------------------------------------------------------
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
