<?php

class KeyringsTableSeeder extends Seeder {

    public function run() {
        DB::table('keyrings')->delete();

        DB::table('keyrings')->insert(array(
            array(
                'account_id' => 1,
                'keyring_host' => 'https://www.google.com',
                'keyring_username' => 'foobar',
                'keyring_password' => Helpers::encryptString(array('string' => 'my_secret_keyring_password_1', 'master_key' => 'master01')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ), array(
                'account_id' => 1,
                'keyring_host' => 'https://www.yahoo.com',
                'keyring_username' => 'foobar',
                'keyring_password' => Helpers::encryptString(array('string' => 'my_secret_keyring_password_2', 'master_key' => 'master01')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ), array(
                'account_id' => 1,
                'keyring_host' => 'http://www.foobar.org',
                'keyring_username' => 'foobar',
                'keyring_password' => Helpers::encryptString(array('string' => 'my_secret_keyring_password_3', 'master_key' => 'master01')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ), array(
                'account_id' => 2,
                'keyring_host' => 'https://www.google.com',
                'keyring_username' => 'joepub',
                'keyring_password' => Helpers::encryptString(array('string' => 'my_secret_keyring_password_1', 'master_key' => 'master02')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ), array(
                'account_id' => 2,
                'keyring_host' => 'http://www.joepub.org',
                'keyring_username' => 'joepub',
                'keyring_password' => Helpers::encryptString(array('string' => 'my_secret_keyring_password_2', 'master_key' => 'master02')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            )
        ));
    }

}
