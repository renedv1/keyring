<?php

class KeyringController extends \BaseController {

    protected $layout = 'layout.master';

    public function __construct() {
        $this->beforeFilter('csrf', array('on' => 'post|put|delete'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function show() {
        $master_key = ( Session::get('master_key') ? Session::get('master_key') : null );
        $keyring_id = ( Session::get('keyring_id') ? Session::get('keyring_id') : null );
        $keyrings = Keyring::where('account_id', '=', Session::get('account_id'))
                ->orderBy('keyring_host', 'asc')
                ->get();
        $this->layout->content = View::make('keyring.index', array(
                    'keyrings' => $keyrings,
                    'master_key' => $master_key,
                    'keyring_id' => $keyring_id
        ));
    }

    /**
     * Show the form for creating a new keyring.
     *
     * @return null
     */
    public function create() {
        $master_key = ( Session::get('master_key') ? Session::get('master_key') : null );
        $keyring_id = ( Session::get('keyring_id') ? Session::get('keyring_id') : null );
        $keyrings = Keyring::where('account_id', '=', Session::get('account_id'))->get();
        $this->layout->content = View::make('keyring.create', array(
                    'keyrings' => $keyrings,
                    'master_key' => $master_key,
                    'keyring_id' => $keyring_id
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $validator = Validator::make(Input::all(), Keyring::$storeKeyringRules);

        if ($validator->passes()) {
            // validation has passed
            // try to save new keyring record in DB
            try {
                $keyring = new Keyring;
                $keyring->account_id = Session::get('account_id');
                $keyring->keyring_host = Input::get('keyring_host');
                $keyring->keyring_username = Input::get('keyring_username');
                $keyring->keyring_password = Helpers::encryptString(array('string' => Input::get('keyring_password'), 'master_key' => Session::get('master_key')));
                $keyring->save();
            } catch (Exception $ex) {
                // save error: display error messages 
                return Redirect::to('/keyring')->with('alert-danger', 'There was an error saving that record:')->withErrors('MySQL error: ' . $ex->getCode())->withInput();
            }

            // save success: redirect to main page
            return Redirect::to('/keyring')->with('alert-success', '"' . $keyring->keyring_host . '" successfully created');
        } else {
            // validation error: display error messages 
            return Redirect::to('/keyring/create')->with('form-errors', 'The following errors occurred:')->withErrors($validator)->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $master_key = ( Session::get('master_key') ? Session::get('master_key') : null );
        $keyring = Keyring::where('id', '=', $id)->get();
        if (!$keyring->isEmpty()) {
            $this->layout->content = View::make('keyring.edit', array(
                        'keyring' => $keyring,
                        'master_key' => $master_key,
            ));
        } else {
            return Redirect::to('/keyring')->with('alert-danger', 'There is no key with that id');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update($id) {
        //set $validator depending on whether a replacement password is supplied
        if (Input::get('keyring_password')) {
            $validator = Validator::make(Input::all(), Keyring::$storeKeyringRules);
        } else {
            $validator = Validator::make(Input::all(), Keyring::$updateKeyringRules);
        }

        //validate form post
        if ($validator->passes()) {
            //validation pass
            //save: update keyring record in DB
            try {
                $keyring = Keyring::find($id);
                $keyring->account_id = Session::get('account_id');
                $keyring->keyring_host = Input::get('keyring_host');
                $keyring->keyring_username = Input::get('keyring_username');
                if (Input::get('keyring_password')) {
                    $keyring->keyring_password = Helpers::encryptString(array('string' => Input::get('keyring_password'), 'master_key' => Session::get('master_key')));
                }
                $keyring->save();
            } catch (Exception $ex) {
                //error: record was not updated - display error messages 
                return Redirect::to('/keyring/edit/' . $id)->with('form-errors', 'There was an error updating that record:')->withErrors('MySQL error: ' . $ex->getCode())->withInput();
            }

            //successful update
            return Redirect::to('/keyring')->with('alert-success', '"' . $keyring->keyring_host . '" was successfully updated');
        } else {
            // validation error: display error messages 
            return Redirect::to('/keyring/edit/' . $id)->with('form-errors', 'The following errors occurred:')->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $keyring = Keyring::find($id);
        if (!empty($keyring)) {
            try {
                $keyring->delete();
                return Redirect::to('/keyring')->with('alert-success', '"' . $keyring->keyring_host . '" was successfully deleted');
            } catch (Exception $ex) {
                return Redirect::to('/keyring/edit/' . $id)->with('form-errors', 'There was an error deleting that record:')->withErrors('MySQL error: ' . $ex->getCode())->withInput();
            }
        }
    }

    //Helper functions//
    //------------------

    /**
     * Authenticate master password for the logged in user
     * Redirects to 'create new key' or 'main keyring page' depending on presence of keyring_id
     * 
     * @return null
     */
    public function checkMasterKey() {
        //setup variables
        $keyring_id = (Input::get('keyring_id') ? Input::get('keyring_id') : null);

        //check for the presence of a master key
        if (Input::has('master_key')) {
            $master_key = Input::get('master_key');

            //use model to test whether the supplied master key is correct
            //test for success condition:
            if (Keyring::checkMasterKey($master_key)) {
                Session::put('master_key', $master_key);
                Session::put('keyring_id', $keyring_id);
            }

            //redirect to appropriate page: 
            // 'keyring main list page' if $keyring_id is not null,
            // 'create new key page' if $keyring is null
            if ($keyring_id) {
                return Redirect::to('/keyring');
            } else {
                return Redirect::to('/keyring/create');
            }
        }

        //fail condition: master_key not supplied or incorrect
        return Redirect::to('/keyring')
                        ->with('alert-warning', 'Error: incorrect or missing password')
                        ->with('keyring_id', $keyring_id);
    }

    /**
     * Hide passwords from view by removing session 'master password'
     * 
     * @return void
     */
    public function relockRecords() {
        Session::remove('master_key');
        return Redirect::to('/keyring');
    }
    
    /**
     * Hide passwords from view by removing session 'master password'
     * 
     * @return void
     */
    public function relockRecord() {
        Session::remove('keyring_id');
        return Redirect::to('/keyring');
    }
    
    //$keyring_id = ( Session::get('keyring_id') ? Session::get('keyring_id') : null );

}
