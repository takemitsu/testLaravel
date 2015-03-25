<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// メディアファイルに必要なもの
		Schema::create('media', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('uuid', 36); // 生成する
			$table->string('filename', 255); // とりあえず
			$table->string('filepath', 255); // ファイルパス
			$table->bigInteger('filesize');  // ファイルサイズ
			$table->string('mime_type', 127); // mime_type
			$table->timestamps();
			$table->softDeletes();
		});
		Schema::table('comments', function($table) {
			$table->integer('media_id')->after('message_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('media');
		Schema::table('comments', function($table) {
			$table->dropColumn(['media_id']);
		});
	}

}
