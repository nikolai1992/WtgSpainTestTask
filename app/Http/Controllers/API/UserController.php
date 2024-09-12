<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\BaseRepository;

class UserController extends Controller
{
    private BaseRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new BaseRepository(new User());
    }
	public function index()
	{
		$users = $this->userRepository->index()->get();

        return UserResource::collection($users);
	}
}
