<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderRequest\DisableOrderRequest;
use App\Http\Requests\Admin\OrderRequest\ViewOrderRequest;
use App\Http\Requests\Admin\ShopRequest\DisableShopRequest;
use App\Services\Admin\OrderService;
use App\Services\Admin\SettingService;

/**
 * Class OrdersController.
 *
 * @package namespace App\Http\Controllers;
 */
class OrdersController extends Controller
{
    protected $orderService;

    protected $settingService;

    public function __construct(OrderService $orderService, SettingService $settingService)
    {
        $this->orderService = $orderService;
        $this->settingService = $settingService;
    }

    public function manageShopOrder(DisableShopRequest $request)
    {
        $data = $this->orderService->manageShopOrder($request);
        $setting = $this->settingService->viewSetting();
        if($data['status']) {
            return view('admin.shoporders.content',[
                'shopOrders' => $data['shopOrders'],
                'shop' => $data['shop'],
                'setting' => $setting['setting'],
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function disableShopOrder(DisableOrderRequest $request)
    {
        if($request->ajax()) {
            $data = $this->orderService->disableShopOrder($request);
            if($data['status']) {
                return json_encode(array('success' => true, 'deleted_at' => $data['shoporder']->deleted_at));
            }
            return json_encode(array('success' => false));
        }
        return json_encode(array('success' => false));
    }

    public function viewDetailOrder(ViewOrderRequest $request)
    {
        if($request->ajax()) {
            $data = $this->orderService->viewDetailOrder($request);
            if($data['status']) {
                return json_encode(array('detail' => view('admin.shoporders.renderdetail')->with(array('products' => $data['listProduct'],'order' => $data['order']))->render()));
            }
            return json_encode(array('detail' => 'Failed!'));
        }
        return json_encode(array('detail' => 'Failed!'));
    }
}
