<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Services\BaseRepository;

class CommentController extends Controller
{
    private BaseRepository $commentRepository;

    public function __construct()
    {
        $this->commentRepository = new BaseRepository(new Comment());
    }
	public function destroy(int $id)
	{
        $result = $this->commentRepository->deleteById($id);
        if ($result) {
            $response = array();
            $response['data']['status'] = true;
            $response['data']['message'] = 'Comment was deleted successfully.';
            $code = 200;
        } else {
            $response['data'] = [
                'success' => false,
                'message' => 'Comment was not found.',
            ];
            $code = 404;
        }

        return response()->json($response, $code);
	}
}
