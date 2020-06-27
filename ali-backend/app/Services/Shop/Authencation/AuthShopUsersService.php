<?php

namespace App\Services\Shop\Authencation;

use Illuminate\Http\Request;

class AuthShopUsersService
{
    public function __construct()
    {

    }

    public function login(Request $request)
    {
        $info = [
            'email' => $request['email'],
            'password' => $request['password']
        ];

        if(auth('web_shop_users')->attempt($info)) {
            return array('status' => true);
        }
        return array('status' => false);
    }

    public function logout(Request $request)
    {
        if(auth('web_shop_users')->logout()) {
            return array('status' => true);
        }
        return array('status' => false);
    }

}
