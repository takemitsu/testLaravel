<?php namespace bbs\Http\Controllers;

use bbs\Http\Requests;
use bbs\Http\Controllers\Controller;

use Illuminate\Contracts\Auth\Guard;

use Request;
use Validator;

use bbs\User;

class UserController extends Controller {

	public function __construct(User $user) {
		$this->middleware('auth');
		$this->user = $user;
	}

	public function index()
	{
		return response()->json($this->user->orderBy('created_at','desc')->paginate(5));
	}

	public function show($id)
	{
		//
	}

	public function update($idkey, Guard $auth)
	{
		$admin = $auth->user();
		if($admin->auth_type == 0) {
			abort(403, 'Access denied');
		}

		$user = $this->user->where('idkey', '=', $idkey)->firstOrFail();

		$inputs = Request::all();
		$v = Validator::make($inputs, [
			'status' => 'between:0,2',
			'auth_type' =>  'between:0,1',
			'name' => 'string:255'
		]);
		if($v->fails()) {
			return redirect()->back()->withErrors($v->errors());
		}
		foreach ($inputs as $key => $value) {
			$user[$key] = $value;
		}
		$user->save();

		return response()->json(array('success' => true));
	}

	public function destroy($idkey)
	{
		$user = $this->user->where('idkey', '=', $idkey)->firstOrFail();
		// 物理削除
		$user->delete();

		return response()->json(array('success' => true));
	}

}
