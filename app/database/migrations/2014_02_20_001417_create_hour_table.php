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
			$table->integer('grille_id')->unsigned();
			$table->foreign('grille_id')->references('id')->on('grilles');

			$table->tinyInteger('day_of_week');	// 0-6 for Sunday-Saturday
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
