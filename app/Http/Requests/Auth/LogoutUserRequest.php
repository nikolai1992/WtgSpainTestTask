<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LogoutUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
	public function rules()
	{
		return [
			'email' => 'required|string|email|max:255',
		];
	}
}
