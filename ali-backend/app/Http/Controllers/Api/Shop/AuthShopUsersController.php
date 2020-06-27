<?php

namespace App\Http\Controllers\Api\Shop;

use App\Entities\Shop;
use App\Services\Shop\Authentication\RegisterService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Shop\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;
use App\Entities\ShopUser;

class AuthShopUsersController extends Controller
{
    /**
     * @var RegisterService
     */
    protected $registerService;

    /**
     * @SWG\Swagger(
     *      schemes={"http", "https"},
     *      @SWG\Info(
     *          version="1.0.0",
     *          title="Shop API",
     *      )
     *  )
     */

    /**
     * AuthShopUsersController constructor.
     * @param RegisterService $registerService
     */
    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    /**
     * @SWG\Post(
     *   path="/api/shop/register",
     *   operationId="register",
     *   tags={"Shop Auth"},
     *   @SWG\Parameter(
     *       name="name",
     *       in="formData",
     *       required=true,
     *       type="string"
     *   ),
     *   @SWG\Parameter(
     *       name="email",
     *       in="formData",
     *       required=true,
     *       type="string"
     *   ),
     *   @SWG\Parameter(
     *       name="phone",
     *       in="formData",
     *       required=true,
     *       type="string"
     *   ),
     *   @SWG\Parameter(
     *       name="password",
     *       in="formData",
     *       required=true,
     *       type="string"
     *   ),
     *   @SWG\Response(response=200, description="successful request"),
     *   @SWG\Response(response=401, description="not authencation"),
     *   @SWG\Response(response=400, description="bad request")
     * )
     *
     */

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
     * @SWG\Post(
     *   path="/api/shop/login",
     *   operationId="login",
     *   tags={"Shop Auth"},
     *   @SWG\Parameter(
     *       name="email",
     *       in="formData",
     *       required=true,
     *       type="string"
     *   ),
     *   @SWG\Parameter(
     *       name="password",
     *       in="formData",
     *       required=true,
     *       type="string"
     *   ),
     *   @SWG\Response(response=200, description="successful request"),
     *   @SWG\Response(response=401, description="not authencation"),
     *   @SWG\Response(response=400, description="bad request")
     * )
     *
     */

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        $user = auth('shop_users')->user();
        if ($user) {
            return $this->responseSuccess('', $user);
        }
        return $this->responseFail();
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

    public function refresh()
    {
        return response(JWTAuth::getToken(), Response::HTTP_OK);
    }
}
