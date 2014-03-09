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
			$table->increments('id');
			$table->string('cs50_id',84);
			$table->string('name');
			$table->string('preferred_name');
			$table->string('phone_number',11)->nullable()->default(NULL);
			$table->string('email');	// TODO: need to look up how @college emails are handled for graduates
			$table->boolean('hours_notification')->default(0);	// text notifications
			$table->boolean('deals_notification')->default(0);
			$table->enum('privileges', array('user','staff','manager', 'admin'))->default('user');

			// if user is associated with a grille as a staff or manager
			$table->integer('grille_id')->unsigned()->nullable()->default(NULL);
			$table->foreign('grille_id')->references('id')->on('grilles');
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
