<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
	public function rules()
	{
		return [
			'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
		];
	}

	public function authorize()
	{
		return true;
	}
}
