<?php

namespace App\Http\Controllers\Api\User;

use App\Services\User\Authentication\RegisterService;
use App\Http\Requests\Api\User\RegisterRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;
use App\Entities\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @var RegisterService
     */
    protected $registerService;

    /**
     * AuthController constructor.
     * @param RegisterService $registerService
     */
    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $data = $this->registerService->registerUser($request);
        if($data['status']) {
            return $this->responseSuccess('', $data['user']);
        }
        return $this->responseFail();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = $this->registerService->loginUser($request);

        if($data['status'] == false) return $this->responseFail();
        return $this->responseSuccess('', array('token' => $data['token'], 'user' => $data['user']));
    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function user(Request $request)
    {
        $user = auth('users')->user();
        if ($user) {
            return response()->json([
                'code' => 200
            ]);
        }
        return json_encode(array('code' => 401));
    }


    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */
    public function logout(Request $request) {
        if($this->registerService->logoutUser($request)) {
            return $this->responseSuccess();
        }
        return $this->responseFail();
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function refresh()
    {
        return response(JWTAuth::getToken(), Response::HTTP_OK);
    }
}
