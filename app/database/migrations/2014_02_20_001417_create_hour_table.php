<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHourTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hours', function($table)
		{
			$table->increments('id');
			$table->integer('grille_id')->unsigned();
			$table->foreign('grille_id')->references('id')->on('grilles');

			// 0 for Sunday through 6 for Saturday
			$table->enum('day_of_week', array('0', '1', '2', '3', '4', '5', '6'));
			$table->time('open_time');
			$table->time('close_time');
         });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('hours');
	}

}
