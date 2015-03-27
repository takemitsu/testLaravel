<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table) {
			$table->string('idkey')->unique()->after('id');
			// status: 認証していない: 0, 認証済み: 1, 利用停止: 2, 削除: 9
			$table->integer('status')->after('name');
			// 権限: 一般ユーザ: 0, 管理ユーザ: 1
			$table->integer('auth_type')->after('status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table) {
			$table->dropColumn(['idkey', 'status','auth_type']);
		});
	}

}
