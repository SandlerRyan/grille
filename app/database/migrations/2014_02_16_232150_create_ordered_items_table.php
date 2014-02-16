<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderedItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ordered_items', function($table)
		{
			$table->integer('order_id')->unsigned();
			$table->foreign('order_id')->references('order_id')->on('orders');
			$table->integer('item_id')->unsigned();
			$table->foreign('item_id')->references('item_id')->on('items');
         });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ordered_items');
	}

}
