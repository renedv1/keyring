<?php

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Eloquent::unguard();

        $this->call('AccountsTableSeeder');
        $this->command->info('accounts table seeded!');
        
        $this->call('KeyringsTableSeeder');
        $this->command->info('keyrings table seeded!');
    }

}
