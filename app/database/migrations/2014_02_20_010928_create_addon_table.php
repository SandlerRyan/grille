<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddonTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('addons', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->decimal('price');
			$table->string('description');
			$table->boolean('available');
			
			$table->integer('grille_id')->unsigned();
			$table->foreign('grille_id')->references('id')->on('grilles');
         });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('addons');
	}

}
