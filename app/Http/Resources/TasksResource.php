<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TasksResource extends JsonResource
{
	public function toArray(Request $request)
	{
		return [
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,
            'status'        => $this->status->name,
            'created_at'    => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
        ];
	}
}
