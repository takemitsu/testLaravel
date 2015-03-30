<?php namespace bbs\Http\Controllers;

use bbs\Http\Requests;
use bbs\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use bbs\User;

class RegisterController extends Controller {

	public function index()
	{
		return view('auth/register');
	}

	public function store(Requests\RegisterUserRequest $request, Guard $auth)
	{
		$input = $request->only('idkey', 'name', 'email', 'password');
		$input['password'] = bcrypt($input['password']);
		$user = User::create($input);
		// $auth->login($user);
		if($auth->user()){
			return redirect('/#/user');
		}
		return redirect('/auth/login');
	}

}
