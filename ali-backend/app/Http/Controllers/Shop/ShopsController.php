<?php

namespace App\Http\Controllers\Shop;

use App\Services\Shop\Order\OrderService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\ShopRepository;
use App\Validators\ShopValidator;
use App\Http\Controllers\Controller;
use App\Services\Shop\ManageShop\ManageShopService;

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

    public function home(Request $request)
    {
        $data = $this->manageShopService->getShopInfo();
        if($data['status']) {
            $shop = $data['shop'];
        } else {
            return redirect()->back();
        }
        $data = $this->orderService->chartForShopToday($request);
        if($data['status']) {

        } else {
            return redirect()->back();
        }
        return view('shop.home.content')->with(['shop' => $shop, 'orders' => $data['orders']]);
    }

    public function changeLanguage($language)
    {
        \Session::put('website_language', $language);

        return redirect()->back();
    }

    public function fixDatabase(Request $request)
    {
        $this->orderService->fixDatabase($request);
    }
}
