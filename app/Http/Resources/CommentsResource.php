<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentsResource extends JsonResource
{
	public function toArray(Request $request)
	{
		return [
            'id' => $this->id,
            'content' => $this->content,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
		];
	}
}
