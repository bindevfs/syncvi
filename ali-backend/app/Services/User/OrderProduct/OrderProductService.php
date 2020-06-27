<?php

namespace App\Services\User\OrderProduct;

use App\Repositories\OrderProductRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use http\Env\Response;
use Illuminate\Http\Request;

class OrderProductService
{
    /**
     * @var OrderRepository
     */
    protected $orderRepo;

    /**
     * @var UserRepository
     */
    protected $userRepo;

    /**
     * @var ProductRepository
     */
    protected $productRepo;

    /**
     * @var OrderProductRepository
     */
    protected $orderProductRepo;

    /**
     * RegisterService constructor.
     * @param UserRepository $userRepo
     */
    public function __construct(OrderRepository $orderRepo, ProductRepository $productRepo,
                                OrderProductRepository $orderProductRepo, UserRepository $userRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->productRepo = $productRepo;
        $this->orderProductRepo = $orderProductRepo;
        $this->userRepo = $userRepo;
    }

    public function removeOrderProduct(Request $request)
    {
        $temp = $request['order_product_id'];

        $order_product = $this->orderProductRepo->findByField('id', $temp)->first();
        if($order_product == null) {
            return array('status' => false, 'message' => 'Have an error!');
        }
        $cart = $this->orderRepo->findWhere(['user_id' => auth('users')->user()->id, 'status' => 0])->first();
        if($order_product->order_id != $cart->id) {
            return array('status' => false, 'message' => 'Can\'t delete product of other user!');
        }

        $this->orderProductRepo->delete($temp);
        return array('status' => true);
    }

    public function updateOrderProduct(Request $request)
    {
        $temp = $request['order_product_id'];

        $order_product = $this->orderProductRepo->findByField('id', $temp)->first();
        if($order_product == null) {
            return array('status' => false, 'message' => 'Not found product!');
        }
        $cart = $this->orderRepo->findWhere(['user_id' => auth('users')->user()->id, 'status' => 0])->first();
        if($order_product->order_id != $cart->id) {
            return array('status' => false, 'message' => 'Can\'t update product of other user!');
        }
        $quality = isset($request['quality']) ? $request['quality'] : $order_product->quality;
        if($quality < 1) $quality = 1;
        $description = isset($request['description']) ? $request['description'] : $order_product->description;
        $order_product = $this->orderProductRepo->update(['quality' => $quality, 'description' => $description], $order_product->id);

        return array('status' => true, 'order_product' => $order_product);
    }
}
