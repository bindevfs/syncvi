<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ShopRequest\DisableShopRequest;
use App\Http\Requests\Admin\ShopUserRequest\DisableShopUserRequest;
use App\Services\Admin\SettingService;
use App\Services\Admin\ShopUserService;
use App\Http\Controllers\Controller;

/**
 * Class ShopUsersController.
 *
 * @package namespace App\Http\Controllers;
 */
class ShopUsersController extends Controller
{
    protected $shopUserService;

    protected $settingService;

    public function __construct(ShopUserService $shopUserService, SettingService $settingService)
    {
        $this->shopUserService = $shopUserService;
        $this->settingService = $settingService;
    }

    public function manageShopUser(DisableShopRequest $request)
    {
        $data = $this->shopUserService->manageShopUser($request);
        $setting = $this->settingService->viewSetting();
        if($data['status']) {
            return view('admin.shopusers.content',[
                'newShopUsers' => $data['newShopUsers'],
                'shopUsers' => $data['shopUsers'],
                'shop' => $data['shop'],
                'setting' => $setting['setting'],
            ]);
        } else return redirect()->back();
    }

    public function disableShopUser(DisableShopUserRequest $request)
    {
        if($request->ajax()) {
            $data = $this->shopUserService->disableShopUser($request);
            if($data['status']) {
                return json_encode(array('success' => true, 'deleted_at' => $data['shopuser']->deleted_at));
            }
            return json_encode(array('success' => false));
        }
        return json_encode(array('success' => false));
    }
}
