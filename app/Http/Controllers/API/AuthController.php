<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\LogoutUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Resources\Auth\RegisterUserResource;
use App\Services\User\UserService;
use Auth;

class AuthController extends Controller
{
    private UserService $userService;
    public function __construct()
    {
        $this->userService = app(UserService::class);
    }
    public function login(LoginUserRequest $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();

            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;
            $success['message'] =  'User Logged In Successfully';

            return $this->sendResponse($success);
        } else{
            return $this->sendError('User with this email was not found in the system.', ['error'=>'Unauthorised']);
        }
    }

    public function sendResponse($result): \Illuminate\Http\JsonResponse
    {
        return response()->json(['data' => $result], 200);

    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404): \Illuminate\Http\JsonResponse
    {
        $response = [];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
            $response['data']['success'] = false;
            $response['data']['message'] = $error;
        } else {
            $response['data'] = [
                'success' => false,
                'message' => $error,
            ];
        }

        return response()->json($response, $code);
    }

    public function register(RegisterUserRequest $request)
    {
        $data = $request->all();
        $user = $this->userService->create($data);

        return response()->json(new RegisterUserResource($user), 200);
    }

    public function logout(LogoutUserRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = $this->userService->index()
            ->where('email', $request->email)
            ->first();
        $token= $user ? $user->tokens()->first() : null;
        if ($token) {
            $token->delete();

            $response = array();
            $response['data']['status'] = true;
            $response['data']['message'] = "Successfully logout";

            return response()->json($response)->header('Content-Type', 'application/json');
        } else {
            return $this->sendError('An authorized user was not found.', ['error'=>'Unlogouted']);
        }

    }
}
