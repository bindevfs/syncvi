<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOrdersTable.
 */
class CreateOrdersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('sum_price')->default(0);
            $table->bigInteger('charge')->default(0);
            $table->bigInteger('deposit')->default(0);
            $table->date('delivery_date')->nullable();
            $table->bigInteger('shop_id')->unsigned()->default(1);
            $table->foreign('shop_id')->references('id')->on('shops');
            $table->integer('status')->default(0);
            $table->tinyInteger('payment')->default(0);
            $table->longText('description')->nullable();
            $table->string('note')->nullable();
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
		Schema::drop('orders');
	}
}
