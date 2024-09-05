<?php

namespace App\Http\Requests\Team;

use Illuminate\Foundation\Http\FormRequest;

class TeamAddUserIntoTeamRequest extends FormRequest
{
	public function rules()
	{
		return [
			'user_id' => 'required|integer|exists:users,id',
		];
	}

	public function authorize()
	{
		return true;
	}
}
