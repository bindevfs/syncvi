<?php


namespace App\Services\Admin;

use App\Repositories\OrderProductRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ShopRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderService
{
    protected $orderRepo;

    protected $shopRepo;

    protected $userRepo;

    protected $orderProRepo;

    protected $productRepo;

    public function __construct(OrderRepository $orderRepo, ShopRepository $shopRepo, UserRepository $userRepo, OrderProductRepository $orderProRepo, ProductRepository $productRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->shopRepo = $shopRepo;
        $this->userRepo = $userRepo;
        $this->orderProRepo = $orderProRepo;
        $this->productRepo = $productRepo;
    }

    public function manageShopOrder(Request $request)
    {
        if($request['shop_id']) {
            $shop_id = $request['shop_id'];
            $shop = $this->shopRepo->find($shop_id);
            $shopOrders = $this->orderRepo->findOrderForShop($shop_id)->paginate(10);
            if ($shopOrders->count() > 0) {
                foreach ($shopOrders as $shopOrder)
                {
                    $user= $this->userRepo->find($shopOrder->user_id);
                    $shopOrder->username = $user->name;
                }
                return array('status' => true, 'shopOrders' => $shopOrders, 'shop' => $shop);
            } else return array('status' => false);
        }
        return array('status' => false);
    }

    public function disableShopOrder(Request $request)
    {
        $shoporder_id = $request['shoporder_id'];
        $shoporder = $this->orderRepo->find($shoporder_id);
        if($shoporder->deleted_at == null) {
            $data = [
                'deleted_at' => Carbon::now(),
            ];
        }
        else {
            $data = [
                'deleted_at' => null,
            ];
        }
        $this->orderRepo->update($data,$shoporder->id);
        return array('status' => true, 'shoporder' => $shoporder);
    }

    public function viewDetailOrder(Request $request)
    {
        $order = $this->orderRepo->find($request['order_id']);
        $listProduct =  $this->orderProRepo->findByField('order_id', $order->id);
        if($listProduct !== null)
            foreach ($listProduct as $product)
            {
                $temp_p = $this->productRepo->find($product->product_id);
                $product->product_key = $temp_p->product_key;
                $product->product_name = $temp_p->product_name;
                $product->resource = $temp_p->resource;
                $product->product_url = $temp_p->product_url;
                $product->thumbnails = $temp_p->thumbnails;
                $product->description = $temp_p->description;
            }
        return array('status' => true, 'order' => $order, 'listProduct' => $listProduct );
    }
}
