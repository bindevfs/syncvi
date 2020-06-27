<?php

namespace App\Services\User\Authentication;

use App\Entities\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterService
{
    /**
     * @var UserRepository
     */
    protected $userRepo;

    /**
     * RegisterService constructor.
     * @param UserRepository $userRepo
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function registerUser(Request $request)
    {
        $params = $request->only('email', 'name', 'password', 'address', 'phone');
        $user = new User();
        $user->email = $params['email'];
        $user->name = $params['name'];
        $user->password = bcrypt($params['password']);
        $user->address = $params['address'];
        $user->phone = $params['phone'];
        $user->shipping_name = $params['name'];
        $user->shipping_phone = $params['phone'];
        $user->shipping_address = $params['address'];

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
        if (!($token = auth('users')->attempt($credentials))) {
            return array('status' => false);
        }
        if(auth('users')->user()->deleted_at != null) {
            JWTAuth::invalidate($token);
            return array('status' => false);
        }
        return array('status' => true, 'token' => $token, 'user' => auth('users')->user());
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
