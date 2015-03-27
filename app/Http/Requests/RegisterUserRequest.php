<?php namespace bbs\Http\Requests;

use bbs\Http\Requests\Request;

class RegisterUserRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'idkey'    => 'required|max:255|unique:users',
			'name'     => 'required|max:255',
			'email'    => 'email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		];
	}

}
