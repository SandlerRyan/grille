<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function($table)
		{
			$table->increments('order_id');
			$table->foreign('user_id')->references('id')->on('users')
			$table->timestamp('created_at');
			$table->string('venmo_id', 15);
			$table->string('notes', 140);
            $table->string('order_status',10)
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
