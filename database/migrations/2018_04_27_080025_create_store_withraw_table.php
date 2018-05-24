<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreWithrawTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_withdraw', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('withdrawID');
			$table->string('status');
			$table->string('ReferenceNumber');
			$table->integer('RejectReason');
			$table->datetime('TransactionDate');
			$table->string('ProofURL');
			$table->decimal('amount');
			$table->datetime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_withdraw');
    }
}
