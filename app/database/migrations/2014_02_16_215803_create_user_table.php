<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table)
		{	
			// primary key is unique 84-char URL yielded by CS50ID,
			// derived from HUID 
			$table->string('id',84)->primary();
			$table->string('name');
			$table->bigInteger('phone_number');
			$table->string('email');	// TODO: need to look up how @college emails are handled for graduates
			$table->boolean('hours_notification')->default(0);	// text notifications
			$table->boolean('deals_notification')->default(0);
			$table->enum('privileges', array('user','staff','manager','admin'))->default('user');
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
		Schema::drop('users');
	}

}
