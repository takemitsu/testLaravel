<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use bbs\Post;
use bbs\Comment;
use bbs\Message;

class PostTableSeeder extends Seeder {

	public function run() {
		DB::table('posts')->delete();
		DB::table('comments')->delete();
		DB::table('messages')->delete();

		Post::create([
			'user_id' => 1,
			'subject' => 'test',
			'comment' => 'comment test!'
		]);

		Comment::create([
			'user_id' => 1,
			'post_id' => 1,
			'comment' => 'child comment!!'
		]);

		Post::create([
			'user_id' => 1,
			'subject' => 'test2',
			'comment' => 'comment test 2!'
		]);

		Message::create([
			'name' => 'takemitsu',
			'subject' => 'test2',
			'comment' => 'comment test 2!'
		]);
	}
}



