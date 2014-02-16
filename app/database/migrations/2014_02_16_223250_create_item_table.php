<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('items', function($table)
		{
			$table->increments('item_id');
			$table->string('item_name');
			$table->float('price');
			/* todo in an edit file--categories table not created yet so will create 
			* migration conflict if run before the categories migration
			* $table->foreign('category_id')->references('category_id')->on('categories') */
			$table->text('description');
			$table->boolean('available');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('items');
	}

}
