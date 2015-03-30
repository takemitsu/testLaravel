<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DefaultSettingUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->integer('status')->default(0)->change();
			$table->integer('auth_type')->default(0)->change();
		});
		Schema::table('user_status_change_logs', function(Blueprint $table)
		{
			$table->integer('before_status')->default(0)->change();
			$table->integer('after_status')->default(0)->change();
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
			//
		});
	}

}
