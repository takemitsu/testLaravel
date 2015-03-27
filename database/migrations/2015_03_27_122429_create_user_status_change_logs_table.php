<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStatusChangeLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_status_change_logs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user_id');
			$table->string('admin_id');
			$table->integer('before_status');
			$table->integer('after_status');
			$table->text('comment');
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
		Schema::drop('user_status_change_logs');
	}

}
