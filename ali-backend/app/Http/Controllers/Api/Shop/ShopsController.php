<?php

namespace App\Http\Controllers\Api\Shop;

use App\Services\Shop\ManageShop\ManageShopService;
use App\Services\Shop\Order\OrderService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\ShopRepository;
use App\Validators\ShopValidator;
use App\Http\Controllers\Controller;

/**
 * Class ShopsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ShopsController extends Controller
{
    protected $manageShopService;

    protected $orderService;

    /**
     * ShopsController constructor.
     *
     * @param ShopRepository $repository
     * @param ShopValidator $validator
     */
    public function __construct(ManageShopService $manageShopService, OrderService $orderService)
    {
        $this->manageShopService = $manageShopService;
        $this->orderService = $orderService;
    }

    /**
     * @SWG\GET(
     *      path="/api/shop/chartShop",
     *      operationId="chartShop",
     *      tags={"Shop"},
     *     security={
     *       {"bearerAuth": {}}
     *     },
     *   @SWG\Response(response=200, description="successful request"),
     *   @SWG\Response(response=401, description="not authencation"),
     *   @SWG\Response(response=400, description="bad request"),
     *     )
     *
     */

    public function chartShop(Request $request)
    {
        $data = $this->manageShopService->getShopInfo();
        if($data['status']) {
            $shop = $data['shop'];
        } else {
            return $this->responseFail();
        }
        $data = $this->orderService->chartForShopToday($request);
        if($data['status']) {
            return $this->responseSuccess('', array('shop' => $shop, 'orders' => $data['orders']));
        }
        return $this->responseFail();
    }

    public function chartOrder(Request $request)
    {
        $data = $this->manageShopService->getShopInfo();
        if($data['status']) {
            $shop = $data['shop'];
        } else {
            return $this->responseFail();
        }
        $data = $this->orderService->chartOrder($request);
        if($data['status']) {
            return $this->responseSuccess('', array('shop' => $shop, 'orders' => $data['orders']));
        }
        return $this->responseFail();
    }

    public function chartProduct(Request $request)
    {
        $data = $this->manageShopService->getShopInfo();
        if($data['status']) {
            $shop = $data['shop'];
        } else {
            return $this->responseFail();
        }
        $data = $this->orderService->chartProduct($request);
        if($data['status']) {
            return $this->responseSuccess('', array('shop' => $shop, 'products' => $data['products']));
        }
        return $this->responseFail();
    }
}
