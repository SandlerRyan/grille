<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddonItaddonItemOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('addon_item_orders', function($table)
		{

			$table->integer('item_order_id')->unsigned();
			$table->foreign('item_order_id')->references('id')->on('item_orders');
			
			$table->integer('addon_id')->unsigned();
			$table->foreign('addon_id')->references('id')->on('addons');

			$table->integer('quantity');
         });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('addon_item_orders');
	}
}
