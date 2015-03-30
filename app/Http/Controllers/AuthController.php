<?php namespace bbs\Http\Controllers;

use bbs\Http\Requests;
use bbs\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;

use Illuminate\Http\Request;
use bbs\User;

class AuthController extends Controller {

	// ログイン画面表示
	public function index()
	{
		return view('auth/login');
	}

	public function table()
	{
		$users = User::orderBy('created_at','desc')->paginate(5);
		return view('auth/list',[
			'users' => $users
		]);
	}

	// ログイン実行
	public function store(Requests\AuthenticateUserRequest $request, Guard $auth)
	{
		$user = User::where('idkey', '=', $request['idkey'])->first();
		if(!$user) {
			return redirect()->back()
				->withInput($request->only('idkey'))
				->withErrors(['name'=>'no user']);
		}
		// if($user->status == 0) {
		// 	return redirect()->back()
		// 		->withInput($request->only('idkey'))
		// 		->withErrors(['name'=>'not approval']);
		// }

		if(! $auth->attempt([
			'idkey' => $request['idkey'],
			'password' => $request['password'],
			// 'status' => 1,
			])) {
			return redirect()->back()
				->withInput($request->only('idkey'))
				->withErrors(['name'=>'check login id or password']);
		}
		return redirect()->intended('/#/index');
	}

	// サインアウト
	public function destroy(Guard $auth)
	{
		$auth->logout();
		return redirect()->intended('/');
	}

}
