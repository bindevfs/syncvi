<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ShopRequest\DisableShopRequest;
use App\Http\Requests\Admin\ShopRequest\FilterShopRequest;
use App\Services\Admin\SettingService;
use App\Services\Admin\ShopService;
use App\Http\Controllers\Controller;

/**
 * Class ShopsController
 * @package App\Http\Controllers\Admin
 */
class ShopsController extends Controller
{
    protected $shopService;

    protected $settingService;

    public function __construct(ShopService $shopService, SettingService $settingService)
    {
        $this->shopService = $shopService;
        $this->settingService = $settingService;
    }

    public function manageShop()
    {
        $data = $this->shopService->manageShop();
        $setting = $this->settingService->viewSetting();
        if($data['status']) {
            return view('admin.shops.content',[
                'shops' => $data['shops'],
                'setting' => $setting['setting'],
            ]);
        }
    }

    public function manageNewShop()
    {
        $data = $this->shopService->manageNewShop();
        if($data['status']) {
            return view('admin.shops.new',[
                'newshops' => $data['newshops'],
            ]);
        }
    }

    public function disableShop(DisableShopRequest $request)
    {
        if($request->ajax()) {
            $data = $this->shopService->disableShop($request);
            if($data['status']) {
                return json_encode(array('success' => true, 'deleted_at' => $data['shop']->deleted_at));
            }
            return json_encode(array('success' => false));
        }
        return json_encode(array('success' => false));
    }

    public function filterShop(FilterShopRequest $request)
    {
        if($request->ajax()) {
            $data = $this->shopService->filterShop($request);
            if($data['status']) {
                return json_encode($data['data']);
            }
            return json_encode(array('success' => false));
        }
        return json_encode(array('success' => false));
    }
}
