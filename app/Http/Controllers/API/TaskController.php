<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TasksAddCommentRequest;
use App\Http\Requests\Task\TaskStoreRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use App\Http\Resources\CommentsResource;
use App\Http\Resources\TasksResource;
use App\Models\Comment;
use App\Models\Task;
use App\Services\BaseRepository;
use Auth;

class TaskController extends Controller
{
    private BaseRepository $taskRepository;
    private BaseRepository $commentRepository;

    public function __construct()
    {
        $this->taskRepository = new BaseRepository(new Task());
        $this->commentRepository = new BaseRepository(new Comment());
    }
	public function index()
	{
        $user = Auth::user();
		return TasksResource::collection($user->tasks);
	}

	public function store(TaskStoreRequest $request)
	{
        $data = $request->validated();
        $user = Auth::user();
        $data['user_id'] = $user->id;
        $task = $this->taskRepository->create($data);

        return response()->json(['data' => $task], 200);
	}

	public function show(int $id)
	{
        $task = $this->taskRepository->getById($id)->get();

        return TasksResource::collection($task);
	}

	public function update(TaskUpdateRequest $request, int $id)
	{
        $data = $request->validated();
        $this->taskRepository->update(id: $id, data: $data);
        $task = $this->taskRepository->getById($id)->first();

        return response()->json(['data' => $task], 200);
	}

	public function destroy(int $id)
	{
        $result = $this->taskRepository->deleteById($id);
        if ($result) {
            $response = array();
            $response['data']['status'] = true;
            $response['data']['message'] = 'Task was deleted successfully.';
            $code = 200;
        } else {
            $response['data'] = [
                'success' => false,
                'message' => 'Task was not found.',
            ];
            $code = 404;
        }

        return response()->json($response, $code);
	}

    public function showComments(int $taskId)
    {
        $task = $this->taskRepository->getById($taskId)->firstOrFail();
        $comments = $task->comments;

        return CommentsResource::collection($comments);
    }

    public function addComment(TasksAddCommentRequest $request, int $taskId)
    {
        $data = $request->validated();
        $user = Auth::user();
        $data['task_id'] = $taskId;
        $data['user_id'] = $user->id;
        $comment = $this->commentRepository->create($data);

        return response()->json(['data' => $comment], 200);
    }
}
