<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJoblistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('joblists', function (Blueprint $table) {
            $table->increments('JobID');
			$table->int('OrderID');
			$table->int('user_id');
			$table->double('total_price');
			$table->integer('cancelcounr');
			$table->datetime('created_at');
			$table->datetime('update_at');
			$table->string('location_address');
			$table->string('LatLng');
			$table->string('currency');
			$table->integer('job_rating');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('joblists');
    }
}
