<?php namespace bbs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model {

	use SoftDeletes;
	protected $dates = ['deleted_at'];

	// 代入を許す属性
	protected $fillable = [
		'uuid',
		'filename',
		'ext',
		'filepath',
		'filesize',
		'mime_type'
	];

}
