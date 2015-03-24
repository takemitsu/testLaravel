<?php namespace bbs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model {

	use SoftDeletes;
	protected $dates = ['deleted_at'];

	protected $fillable = [
		'message_id',
		'name',
		'comment'
	];

}
