<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
{
	public function rules()
	{
		return [
            'title'       => 'required|max:255',
            'description' => 'nullable',
            'status'      => 'max:255|required',
            'team_id'     => 'nullable|numeric|integer',
		];
	}

	public function authorize()
	{
		return true;
	}
}
