<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
			$table->string('Name');
			$table->double('Price');
			$table->string('Description');
			$table->string('Currency');
			$table->string('ImageURL');
			$table->integer('QuantityPerPackage');
			$table->integer('Status');
			$table->decimal('Discount');
			$table->datetime('Created_at');
			$table->datetime('Update_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
