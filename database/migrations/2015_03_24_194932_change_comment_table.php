<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCommentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('comments', function($table) {
			$table->dropColumn(['post_id', 'user_id']);
			$table->integer('message_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('comments', function($table) {
			$table->integer('post_id');
			$table->integer('user_id');
			$table->dropColumn(['message_id']);
		});
	}

}
