<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddonItemTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('addon_items', function($table)
		{
			$table->integer('item_id')->unsigned();
			$table->foreign('item_id')->references('id')->on('items');

			$table->integer('addon_id')->unsigned();
			$table->foreign('addon_id')->references('id')->on('addons');
         });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('addon_items');
	}
}
