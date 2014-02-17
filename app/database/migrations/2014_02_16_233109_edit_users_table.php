<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			// made phone number field too small; needs to be regular int, not smallint
			$table->dropColumn('phone_number');
		});
		Schema::table('users', function(Blueprint $table)
		{
			$table->bigInteger('phone_number');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn('phone_number');

		});

		Schema::table('users', function(Blueprint $table)
		{
			$table->smallInteger('phone_number');
		});
	}

}
