<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserRequest\DisableUserRequest;
use App\Http\Requests\Admin\UserRequest\FilterUserRequest;
use App\Http\Requests\Admin\UserRequest\SortUserRequest;
use App\Services\Admin\SettingService;
use App\Services\Admin\UserService;
use App\Http\Controllers\Controller;

/**
 * Class UsersController.
 *
 * @package namespace App\Http\Controllers;
 */
class UsersController extends Controller
{
    protected $userService;

    protected $settingService;

    public function __construct(UserService $userService, SettingService $settingService)
    {
        $this->userService = $userService;
        $this->settingService = $settingService;
    }

    public function manageUser()
    {
        $data = $this->userService->manageUser();
        $setting = $this->settingService->viewSetting();
        if($data['status']) {
            return view('admin.users.content',[
                'users' => $data['users'],
                'setting' => $setting['setting'],
            ]);
        }
    }

    public function manageNewUser()
    {
        $data = $this->userService->manageNewUser();
        if($data['status']) {
            return view('admin.users.new',[
                'newusers' => $data['newusers'],
            ]);
        }
    }

    public function disableUser(DisableUserRequest $request)
    {
        if($request->ajax()) {
            $data = $this->userService->disableUser($request);
            if($data['status']) {
                return json_encode(array('success' => true, 'deleted_at' => $data['user']->deleted_at));
            }
            return json_encode(array('success' => false));
        }
        return json_encode(array('success' => false));
    }

    public function filterUser(FilterUserRequest $request)
    {
        if($request->ajax()) {
            $data = $this->userService->filterUser($request);
            if($data['status']) {
                return json_encode($data['data']);
            }
            return json_encode(array('success' => false));
        }
        return json_encode(array('success' => false));
    }
}
