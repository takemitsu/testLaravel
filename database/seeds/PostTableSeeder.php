<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use bbs\Post;
use bbs\Comment;

class PostTableSeeder extends Seeder {

	public function run() {
		DB::table('posts')->delete();
		DB::table('comments')->delete();

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
	}
}



