<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
	public function toArray(Request $request)
	{
		return [
            'id' => $this->id,
            'name' => $this->name,
            'team_members' => UserResource::collection($this->teamMembers),
		];
	}
}
