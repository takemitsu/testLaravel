<?php namespace bbs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model {

	use SoftDeletes;

	protected $fillable = [
		'name',
		'subject',
		'comment'
	];

	protected $dates = ['deleted_at'];

}
