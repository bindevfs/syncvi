<?php

namespace App\Http\Controllers\Shop;

use App\Entities\Shop;
use App\Services\Shop\Authentication\RegisterService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Shop\RegisterRequest;
use App\Services\Shop\Authencation\AuthShopUsersService;

class AuthShopUsersController extends Controller
{
    /**
     * @var RegisterService
     */
    protected $registerService;

    protected $authShopUsersService;

    /**
     * AuthShopUsersController constructor.
     * @param RegisterService $registerService
     */
    public function __construct(RegisterService $registerService, AuthShopUsersService $authShopUsersService)
    {
        $this->registerService = $registerService;
        $this->authShopUsersService = $authShopUsersService;
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $data = $this->registerService->registerUser($request);
        if($data['status']) {
            return redirect()->route('shop.login.view');
        }
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = $this->authShopUsersService->login($request);

        if($data['status'] == false) return redirect()->back();
        return redirect()->route('shop.home');
    }

    public function logout(Request $request)
    {
        $data = $this->authShopUsersService->logout($request);
        if($data['status']) {
            return redirect()->route('shop.login.view');
        }
        return redirect()->back();
    }
}
