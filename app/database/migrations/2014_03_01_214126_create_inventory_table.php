<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inventories', function($table)
		{
			$table->increments('id');
			$table->integer('grille_id')->unsigned();
			$table->foreign('grille_id')->references('id')->on('grilles');

			$table->string('name');
			$table->string('description');
			$table->integer('quantity')->unsigned();
			$table->string('units');		// e.g. pounds, bags, boxes, etc.
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('inventories');
	}

}
