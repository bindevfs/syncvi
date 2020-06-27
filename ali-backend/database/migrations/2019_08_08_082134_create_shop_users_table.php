<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateShopUsersTable.
 */
class CreateShopUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_users', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email',191)->unique();
            $table->string('password');
            $table->string('phone');
            $table->bigInteger('shop_id')->unsigned()->default(1);
            $table->foreign('shop_id')->references('id')->on('shops');
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
		Schema::drop('shop_users');
	}
}
