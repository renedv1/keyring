<?php
/**
 * Helper functions a la CodeIgniter...
 *
 * @author zero
 * 
 * SCRATCHPAD :: Code snippets here...
 * -----------------------------------
 * //like: CI echo $this->db->last_query();
 * echo Helpers::prePrintR(DB::getQueryLog());
 * 
 * //like...
 * [code here]
 * 
 * etc
 */
class Helpers {

    /**
     * Returns a nicely formatted array surrounded by <pre> tags
     * 
     * @param array|object $a Input array or Object
     * 
     * @return string
     */
    public static function prePrintR($a) {

        $ret = "<pre>";
        $ret .= print_r($a, true);
        $ret .= "</pre>";

        return $ret;
    }

    /**
     * Encrypt a string using a master password
     * 
     * @param array $a array('string'=>'password [string] to encrypt', 'master_key'=>'password to unlock encryption')
     * 
     * @return string
     */
    public static function encryptString($a) {

        $string = $a['string'];
        $master_key = $a['master_key'];

        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($master_key), $string, MCRYPT_MODE_CBC, md5(md5($master_key))));
        
        return $encrypted;
    }

    /**
     * Decrypt a string using a master password
     * 
     * @param array $a array('string'=>'password [string] to decrypt', 'master_key'=>'password to unlock encryption')
     * 
     * @return string
     */
    public static function decryptString($a) {
       
        $string = $a['string'];
        $master_key = $a['master_key'];

        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($master_key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($master_key))), "\0");
        
        return $decrypted;
    }
    
    
}
