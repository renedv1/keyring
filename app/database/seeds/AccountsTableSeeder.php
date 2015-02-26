<?php

class AccountsTableSeeder extends Seeder {

    public function run() {
        DB::table('accounts')->delete();

        DB::table('accounts')->insert(array(
            array(
                'id' => 1,
                'first_name' => 'Foo',
                'last_name' => 'Bar',
                'email' => 'foo@bar.com',
                'password' => Hash::make('passwd01'),
                'master_password' => Helpers::encryptString(array('string'=>'master01', 'master_password'=>'master01')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ),
            array(
                'id' => 2,
                'first_name' => 'Joe',
                'last_name' => 'Public',
                'email' => 'joe@public.com',
                'password' => Hash::make('passwd02'),
                'master_password' => Helpers::encryptString(array('string'=>'master02', 'master_password'=>'master02')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            )
        ));
    }

}
