<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateProductsTable.
 */
class CreateProductsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_key', 100)->unique();
            $table->string('product_name');
            $table->string('resource');
            $table->longText('product_url');
            $table->string('thumbnails');
            $table->bigInteger('shop_id')->unsigned()->nullable();
            $table->bigInteger('cost')->nullable();
            $table->bigInteger('sell_price')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->time('deleted_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}
}
