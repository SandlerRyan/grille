<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('item_orders', function($table)
		{
			$table->integer('order_id')->unsigned();
			$table->foreign('order_id')->references('id')->on('orders');

			$table->integer('item_id')->unsigned();
			$table->foreign('item_id')->references('id')->on('items');

			$table->integer('addon_id')->unsigned()->nullable()->default(NULL);
			$table->foreign('addon_id')->references('id')->on('addons');
			
			$table->integer('quantity');
			$table->string('notes');
         });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('item_orders');
	}

}
