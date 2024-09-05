<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TasksAddCommentRequest extends FormRequest
{
	public function rules()
	{
		return [
			'content' => 'required|string'
		];
	}

	public function authorize()
	{
		return true;
	}
}
