<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\TeamAddUserIntoTeamRequest;
use App\Http\Requests\Team\TeamStoreRequest;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use App\Services\BaseRepository;
use App\Services\User\UserService;

class TeamController extends Controller
{
    private BaseRepository $teamRepository;
    /**
     * @var UserService|(UserService&\Illuminate\Contracts\Foundation\Application)|\Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|mixed
     */
    private UserService $userService;

    public function __construct()
    {
        $this->teamRepository = new BaseRepository(new Team());
        $this->userService = app(UserService::class);
    }
	public function index()
	{
        $teams = $this->teamRepository->index()->get();
        return TeamResource::collection($teams);
	}
    public function store(TeamStoreRequest $request)
    {
        $data = $request->validated();
        $team = $this->teamRepository->create($data);

        return response()->json(['data' => $team], 200);
    }

    public function addUserIntoTeam(TeamAddUserIntoTeamRequest $request, int $teamId)
    {
        $team = $this->teamRepository->getById($teamId)->firstOrFail();
        $user = $this->userService->getById($request->user_id)->first();
        $user->teams()->attach($team);

        $response = $this->prepareSuccessfulResponse('User was added into team successfully.');

        return response()->json($response, 200);
    }

    public function removeUserFromTeam(int $teamId, int $userId)
    {
        $team = $this->teamRepository->getById($teamId)->firstOrFail();
        $user = $this->userService->getById($userId)->firstOrFail();
        $user->teams()->detach($team);

        $response = $this->prepareSuccessfulResponse('User was removed from team successfully.');

        return response()->json($response, 200);
    }

    private function prepareSuccessfulResponse($message): array
    {
        $response = array();
        $response['data']['status'] = true;
        $response['data']['message'] = $message;

        return $response;
    }
}
