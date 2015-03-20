<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id');
			// ユーザID
			$table->integer('user_id');
			// 件名
			$table->string('subject', 255);
			// 内容
			$table->text('comment');
			// タイムスタンプ
			$table->timestamps();
		});

		Schema::create('comments', function(Blueprint $table)
		{
			$table->increments('id');
			// post_id
			$table->integer('post_id');
			// user_id
			$table->integer('user_id');
			// 内容
			$table->text('comment');
			// タイムスタンプ
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
		Schema::drop('posts');
		Schema::drop('comments');
	}

}
