<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Account extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'accounts';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');

    /**
     * Account creation form validation ruleset
     * 
     * @var array
     */
    public static $storeAccountRules = array(
        'first_name' => 'required|alpha|between:2,64',
        'last_name' => 'required|alpha|between:2,64',
        'email' => 'required|email|unique:accounts|max:64',
        'password' => 'required|alpha_num|between:6,12|confirmed',
        'password_confirmation' => 'required|alpha_num|between:6,12'
    );
    
    /**
     * Master key creation form validation ruleset
     * 
     * @var array
     */
    public static $storeMasterKeyRules = array(
        'account_id' => 'required|numeric',
        'master_key' => 'required|alpha_num|between:6,12|confirmed',
        'master_key_confirmation' => 'required|alpha_num|between:6,12'
    );
    
    /**
     * Tests if the user has a master_key db entry already
     * 
     * Returns true is master_key is present 
     * Returns false if master_key is not present
     * 
     * @return boolean
     */
    public static function isMasterKeySet() {
        //retrieve the [logged in] user's database record
        $user_object = Account::where('email', '=', Session::get('email'))->first();
        $master_key = $user_object->master_key;
        
        if ($master_key) {
            return true;
        }
        return false;
    }


}
