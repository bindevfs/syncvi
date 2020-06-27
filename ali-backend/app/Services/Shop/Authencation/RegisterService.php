<?php

namespace App\Services\Shop\Authentication;

use App\Entities\ShopUser;
use App\Repositories\ShopUserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterService
{
    /**
     * @var ShopUserRepository
     */
    protected $shopUserRepo;

    /**
     * RegisterService constructor.
     * @param ShopUserRepository $userRepo
     */
    public function __construct(ShopUserRepository $shopUserRepo)
    {
        $this->shopUserRepo = $shopUserRepo;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function registerUser(Request $request)
    {
        $params = $request->only('email', 'name', 'password', 'phone');
        $user = new ShopUser();
        $user->email = $params['email'];
        $user->name = $params['name'];
        $user->password = bcrypt($params['password']);
        $user->phone = $params['phone'];
        $user->shop_id = isset($request['shop_id']) ? $request['shop_id'] : 1;

        try {
            $user->save();
        } catch (\Exception $exception) {
            return array('status' => false, 'user' => $user);
        }

        return array('status' => true, 'user' => $user);
    }

    public function loginUser(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!($token = auth('shop_users')->attempt($credentials))) {
            return array('status' => false);
        }
        if(auth('shop_users')->user()->deleted_at != null) {
            JWTAuth::invalidate($token);
            return array('status' => false);
        }
        return array('status' => true, 'token' => $token, 'user' => auth('shop_users')->user());
    }

    public function logoutUser(Request $request)
    {
        try {
            JWTAuth::invalidate($request->input('token'));
            return true;
        } catch (JWTException $e) {
            return false;
        }
    }
}
