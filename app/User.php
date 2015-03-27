<?php namespace bbs;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use bbs\UserStatusChangeLog;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'idkey', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * ステータス変更
	 */
	public function changeStatus($status, $admin, $comment) {
		$old_status = $this->status;
		$this->status = $status;
		$this->save();
		// 変更履歴に追加
		UserStatusChangeLog::create([
			'user_id'       => $this->id,
			'admin_id'      => $admin->id,
			'before_status' => $old_status,
			'after_status'  => $status,
			'comment'       => $comment
		]);
	}

	/**
	 * 権限変更
	 * 0: normal, 1: admin, 2: super!?
	 */
	public function changeAuthType($type) {
		$this->auth_type = $type;
		$this->save();
	}
}
