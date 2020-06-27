<?php

namespace App\Services\Shop\ManageShop;

use App\Repositories\OrderRepository;
use App\Repositories\ShopRepository;
use Illuminate\Http\Request;

class ManageShopService
{
    protected $shopRepo;

    protected $orderRepo;

    public function __construct(ShopRepository $shopRepo, OrderRepository $orderRepo)
    {
        $this->shopRepo = $shopRepo;
        $this->orderRepo = $orderRepo;
    }

    public function getShopInfo()
    {
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if($shop = $this->shopRepo->findByField('id', $user->shop_id)->first()) {
            $orders = $this->orderRepo->findWhere(['shop_id' => $shop->id, 'status' => 1, 'delivery_date' => null]);
            if($orders->count() >= 1) {
                $shop->check = true;
            }
            return array('status' => true, 'shop' => $shop);
        }
        return array('status' => false);
    }
}
