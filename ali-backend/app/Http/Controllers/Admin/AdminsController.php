<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminRequest\DeleteAdminRequest;
use App\Http\Requests\Admin\AdminRequest\FilterAdminRequest;
use App\Http\Requests\Admin\AdminRequest\LoginAdminRequest;
use App\Http\Requests\Admin\AdminRequest\LogoutAdminRequest;
use App\Http\Requests\Admin\AdminRequest\RegisterAdminRequest;
use App\Services\Admin\AdminService;
use App\Http\Controllers\Controller;
use App\Services\Admin\SettingService;

/**
 * Class AdminsController.
 *
 * @package namespace App\Http\Controllers;
 */
class AdminsController extends Controller
{

    protected $adminService;

    protected $settingService;

    /**
     * AdminsController constructor.
     * @param AdminService $adminService
     */
    public function __construct(AdminService $adminService, SettingService $settingService)
    {
        $this->adminService = $adminService;
        $this->settingService = $settingService;
    }

    public function welcomeLogin()
    {
        return view('admin.login');
    }

    public function welcomeRegister()
    {
        return view('admin.register');
    }

    public function index()
    {
        return view('admin.index');
    }

    public function loginAdmin(LoginAdminRequest $request)
    {
        $data = $this->adminService->loginAdmin($request);
        if($data['admin'] === null) {
            return redirect()->route('login');
        } else if ($data['admin']->roles === 4) {
            return redirect()->route('login');
        } else if($data['status'] == true) {
            return redirect()->route('welcome');
        } else if($data['status'] == false){
            return redirect()->route('login');
        }
    }


    public function registerAdmin(RegisterAdminRequest $request)
    {
        $data = $this->adminService->registerAdmin($request);
        if($data['status']) {
            return redirect('/')->with('status','Please check your email to validate your account.');
        }
    }

    public function activateAdmin($token)
    {
        $data = $this->adminService->activateAdmin($token);
        if($data['status']) {
            return redirect()->route('welcome');
        }
    }

    public function welcome()
    {
        $setting = $this->settingService->viewSetting();
        return view('admin.home.content', [
            'setting' => $setting['setting'],
        ]);
    }

    public function logoutAdmin(LogoutAdminRequest $request)
    {
        $data = $this->adminService->logoutAdmin($request);
        return $data ?: redirect('/');
    }

    public function manageAdmin()
    {
        $data = $this->adminService->manageAdmin();
        $setting = $this->settingService->viewSetting();
        if($data['status']) {
            return view('admin.admins.content', [
                'admins' => $data['admins'],
                'setting' => $setting['setting'],
            ]);
        }
    }

    public function manageNewAdmin()
    {
        $data = $this->adminService->manageNewAdmin();
        if($data['status']) {
            return view('admin.admins.new', [
                'newadmins' => $data['newadmins'],
            ]);
        }
    }

    public function deleteAdmin(DeleteAdminRequest $request)
    {
        if($request->ajax()) {
            $data = $this->adminService->deleteAdmin($request);
            if($data['status']) {
                return json_encode(true);
            }
            return json_encode(false);
        }
        return json_encode(false);
    }

    public function filterAdmin(FilterAdminRequest $request)
    {
        if($request->ajax()) {
            $data = $this->adminService->filterAdmin($request);
            if($data['status']) {
                return json_encode($data['data']);
            }
            return json_encode(array('status' => false));
        }
        return json_encode(array('status' => false));
    }
}
