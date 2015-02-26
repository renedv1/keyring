<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeyringsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('keyrings', function($table) {
            $table->increments('id');
            $table->mediumInteger('account_id')->unsigned();
            $table->string('keyring_host', 64);
            $table->string('keyring_username', 64);
            $table->string('keyring_password', 128);
            $table->timestamps();
            $table->unique(array('keyring_host', 'keyring_username'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('keyrings');
    }

}
