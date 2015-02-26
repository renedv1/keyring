<?php

class Keyring extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'keyrings';

    /**
     * Form validation ruleset
     * 
     * @var array 
     */
    public static $storeKeyringRules = array(
        'keyring_host' => 'required|between:2,64',
        'keyring_username' => 'required|regex:/^([a-z0-9.@_])+$/i|between:2,64',
        'keyring_password' => 'required|between:2,32|confirmed',
        'keyring_password_confirmation' => 'required|between:2,32'
    );
    
    public static $updateKeyringRules = array(
        'keyring_host' => 'required|between:2,64',
        'keyring_username' => 'required|regex:/^([a-z0-9.@_])+$/i|between:2,64',
    );
    
    /**
     * Decrypt db master key with supplied master key and check for a match
     * 
     * @param string $master_key
     * @return boolean
     */
    public static function checkMasterKey($master_key) {
        //retrieve the [logged in] user's database record
        $user_object = Account::where('email', '=', Session::get('email'))->first();
        
        //extract the encrypted master_key string
        $encrypted_master_key = $user_object->master_key;

        //attempt to decrypt the encrypted master_key string using the supplied $master_key
        $decrypted_master_key = rtrim(mcrypt_decrypt(
                        MCRYPT_RIJNDAEL_256, md5($master_key), base64_decode($encrypted_master_key), MCRYPT_MODE_CBC, md5(md5($master_key))), "\0"
        );

        //compare the results, return true if a match is found
        if ($decrypted_master_key == $master_key) {
            return true;
        }

        //incorrect master_key was supplied
        return false;
    }
    
    
}
