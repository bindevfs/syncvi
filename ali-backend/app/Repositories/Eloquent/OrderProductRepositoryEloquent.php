<?php

namespace App\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OrderProductRepository;
use App\Entities\OrderProduct;
use App\Validators\OrderProductValidator;
use App\Entities\Order;

/**
 * Class OrderProductRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OrderProductRepositoryEloquent extends BaseRepository implements OrderProductRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderProduct::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return OrderProductValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function checkOwner($order_product_id)
    {
        $order_product = $this->findByField('id', $order_product_id)->first();
        if($order_product == null) {
            return false;
        }
        $cart = Order::where('user_id', auth('users')->user()->id)->where('status', 0)->first();
        if($cart == null) {
            return false;
        }
        if($order_product->order_id != $cart->id) {
            return false;
        }
        return true;
    }

    public function orderProductRequestingOfShop($shop_id)
    {
        $orderProducts = OrderProduct::select('order_products.id', 'order_products.product_id', 'order_products.order_id', 'order_products.quality',
            'order_products.price', 'order_products.status')->join('orders', 'orders.id', '=', 'order_products.order_id')
            ->where('orders.shop_id', $shop_id)->where('orders.status', Order::STATUS_PAID);
        return $orderProducts;
    }

    public function findAllOrderOfProduct($product_id, $shop_id)
    {
        $orderProducts = OrderProduct::select('order_products.*')->Join('orders', 'orders.id', '=', 'order_products.order_id')
                        ->where('product_id', $product_id)->where('shop_id', $shop_id)->where('orders.status', Order::STATUS_PAID);
        return $orderProducts;
    }
}
