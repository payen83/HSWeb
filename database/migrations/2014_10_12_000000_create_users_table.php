<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
			$table->string('api_token');
            $table->string('remember_token');
			$table->datetime('created_at');
			$table->datetime('updated_at');
			$table->integer('status');
			$table->string('icnumber');
			$table->string('u_address');
			$table->string('url_image');
			$table->string('u_bankname');
			$table->string('u_accnumber');
			$table->string('u_phone');
			$table->string('role');
			$table->string('u_rating');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
