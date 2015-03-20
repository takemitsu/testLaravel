<?php namespace bbs;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {

	//
	public function comments()
	{
		return $this->hasMany('bbs\Comment');
	}

}
