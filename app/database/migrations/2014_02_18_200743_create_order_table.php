<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function($table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');

			$table->integer('grille_id')->unsigned();
			$table->foreign('grille_id')->references('id')->on('grilles');

			$table->string('venmo_id', 19)->nullable();	// if null, user hasn't paid yet
			$table->boolean('cooked')->default(0);
			$table->boolean('fulfilled');	// checked off when the user picks up their food
			$table->boolean('refunded')->default(0);
			$table->boolean('cancelled')->default(0);
            $table->decimal('cost');
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
		Schema::drop('orders');
	}

}
