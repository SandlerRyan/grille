<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrilleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('grilles', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->bigInteger('phone_number');

			$table->integer('manager_id')->unsigned();
			$table->foreign('manager_id')->references('id')->on('users');
			$table->boolean('open_now');
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
		Schema::drop('grilles');
	}

}
