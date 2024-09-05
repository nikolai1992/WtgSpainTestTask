<?php

namespace App\Models;

use App\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];
    protected $casts = [
        'status' => TaskStatusEnum::class,
    ];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function team()
	{
		return $this->belongsTo(Team::class);
	}

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
