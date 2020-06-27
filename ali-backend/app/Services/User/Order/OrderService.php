<?php

namespace App\Services\User\Order;

use App\Repositories\CommentRepository;
use App\Repositories\OrderProductRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ShopRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Entities\Order;
use PHPUnit\Framework\Constraint\IsNan;

class OrderService
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
     * @var ShopRepository
     */
    protected $shopRepo;

    /**
     * @var OrderProductRepository
     */
    protected $orderProductRepo;

    protected $commentRepo;

    /**
     * RegisterService constructor.
     * @param UserRepository $userRepo
     */
    public function __construct(OrderRepository $orderRepo, ProductRepository $productRepo, CommentRepository $commentRepo,
                                OrderProductRepository $orderProductRepo, UserRepository $userRepo, ShopRepository $shopRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->productRepo = $productRepo;
        $this->orderProductRepo = $orderProductRepo;
        $this->userRepo = $userRepo;
        $this->shopRepo = $shopRepo;
        $this->commentRepo = $commentRepo;
    }

    public function addToCart(Request $request)
    {
        $product_key = $request['product_key'];
        $product_name = $request['product_name'];
        $resource = $request['resource'];
        $product_url = $request['product_url'];
        $thumbnails = $request['thumbnails'];
        $description = isset($request['description']) ? $request['description'] : '';
        $price = $request['price'];
        $quality = isset($request['quality']) ? $request['quality'] : 1;
        if(!is_numeric($quality)) $quality = 1;
        //check if product already create before. (same product_key)
        $product = $this->productRepo->findByField('product_key', $product_key)->first();
        if($product === null) {
            //if not: create a new product
            $product = $this->productRepo->create([
                'product_key'=> $product_key,
                'product_name' => $product_name,
                'resource' => $resource,
                'product_url' => $product_url,
                'thumbnails' => $thumbnails,
            ]);
        }
        //check if something went wrong make $product can't create successfully
        if($product === null) {
            return array('status' => false);
        }

        //find currently cart which is a order have status = 0
        $cart = $this->orderRepo->findWhere(['user_id' => auth('users')->user()->id, 'status' => Order::STATUS_CART])->first();
        if($cart === null) {
            //if not: create a cart
            $cart = $this->orderRepo->create([
                'user_id' => auth('users')->user()->id,
                'sum_price' => 0,
            ]);
        }

        //check if order_product already exist in cart
        $order_product = $this->orderProductRepo->findWhere(['product_id' => $product->id, 'order_id' => $cart->id])->first();
        if($order_product === null) {
            //if not: create one (note that order_id should be $cart->id)
            $order_product = $this->orderProductRepo->create([
                'product_id' => $product->id,
                'order_id' => $cart->id,
                'quality' => $quality,
                'price' => $price,
                'description' => $description
            ]);
        } else {
            if($order_product->description == $description) {
                //if it's exits before: easy update quality.
                $order_product = $this->orderProductRepo->update([
                    'quality' => ($order_product->quality + $quality)
                ], $order_product->id);
            } else {
                $order_product = $this->orderProductRepo->create([
                    'product_id' => $product->id,
                    'order_id' => $cart->id,
                    'quality' => $quality,
                    'price' => $price,
                    'description' => $description
                ]);
            }
        }

        //return a successfully response with order product infor
        return array('status' => true, 'order_product' => $order_product);
    }

    public function viewCart(Request $request)
    {
        //check if cart exist, if not: create a cart with 0 product inside
        $cart = $this->orderRepo->findWhere(['user_id' => auth('users')->user()->id, 'status' => Order::STATUS_CART])->first();
        if($cart === null) {
            $cart = $this->orderRepo->create([
                'user_id' => auth('users')->user()->id,
                'sum_price' => 0,
            ]);

            //make sure cart have 0 product inside. return with user  to send shipping information
            $user = auth('users')->user();
            return array('status' => true, 'listProduct' => [], 'user' => $user);
        }

        //if cart exist before, find all product inside it.
        $listProduct =  $this->orderProductRepo->findByField('order_id', $cart->id);
        if($listProduct !== null)
            foreach ($listProduct as $p)
            {
                $t = $this->productRepo->find($p->product_id);
                $p->product_key = $t->product_key;
                $p->product_name = $t->product_name;
                $p->resource = $t->resource;
                $p->product_url = $t->product_url;
                $p->thumbnails = $t->thumbnails;
                //$p->description = $t->description;
            }

        //return with user to send shipping information.
        $user = auth('users')->user();
        if($user->shipping_name == '' || $user->shipping_phone == '' || $user->shipping_address == '')
        {
            $this->userRepo->update([
                'shipping_name'     => $user->name,
                'shipping_phone'    => $user->phone,
                'shipping_address'  => $user->address
            ], $user->id);
        }
        return array('status' => true, 'listProduct' => $listProduct, 'user' => $user);
    }

    public function order(Request $request)
    {
        //prepare
        $listOP = $request['order_products'];
        $shipping_name = $request['shipping_name'];
        $shipping_phone = $request['shipping_phone'];
        $shipping_address = $request['shipping_address'];
        $save = $request['save'];
        if($save == null) {
            $save = 0;
        }
        //save shipping information for later order time.
        if($save) {
            $user = $this->userRepo->update([
                'shipping_name' => $shipping_name,
                'shipping_phone' => $shipping_phone,
                'shipping_address' => $shipping_address
            ], auth('users')->user()->id);
        }
        //create shipping information and save it to 'description' of order.
        //user can't change this description
        $allShipInfor = $shipping_name.' | '.$shipping_phone.' | '.$shipping_address;

        $order = $this->orderRepo->findWhere(['user_id' => auth('users')->user()->id, 'status' => Order::STATUS_PROCESSING])->first();
        if($order == null) {
            $order = $this->orderRepo->create([
                'user_id' => auth('users')->user()->id,
                'sum_price' => 0,
                'description' => $allShipInfor,
                'status' => Order::STATUS_PROCESSING
            ]);
        }
        $sum = $order->sum_price;
        $cart = $this->orderRepo->findWhere(['user_id' => auth('users')->user()->id, 'status' => Order::STATUS_CART])->first();
        //$cart = $this->orderRepo->findByField('user_id', auth('users')->user()->id)->first();
        //start order
        if(is_array($listOP)) {
            foreach ($listOP as $OP)
            {
                $temp = null;
                $temp = $this->orderProductRepo->findByField('id', $OP)->first();
                if($temp == null) continue;
                if($temp->order_id != $cart->id) {
                    continue;
                }
                $sum += $temp->price * $temp->quality;
                $this->orderProductRepo->update([
                    'order_id' => $order->id
                ], $temp->id);
            }
        } else {
            $temp = $this->orderProductRepo->findByField('id', $listOP)->first();
            if($temp == null) {
                return array('status' => false, 'message' => '');
            }
            if($temp->order_id == $cart->id) {
                $this->orderProductRepo->update([
                    'order_id' => $order->id
                ], $temp->id);
            } else {
                return array('status' => false, 'message' => 'error');
            }
            $sum += $temp->price * $temp->quality;
        }

        /// charge 3.5%
        $charge = ((int)((float) $sum*Order::PERCENT_CHARGE)/1000) * 1000;

        //finish
        $order = $this->orderRepo->update([
            'sum_price' => $sum,
            'charge' => $charge,
            'created_at' => Carbon::now()->toDateTimeString()
        ], $order->id);
        return array('status' => true, 'order' => $order);
    }

    public function allOrderRejected()
    {
        $user = auth('users')->user();
        $orders = $this->orderRepo->findWhere(['status' => Order::STATUS_CANCEL, 'user_id' => $user->id]);
        return array('status' => true, 'orders' => $orders);
    }

    public function listOrder(Request $request)
    {
        //just get order of this user and not deleted before (deleted_at == null)
        $orders = $this->orderRepo->allOrderUser(auth('users')->user()->id)->get();
        foreach ($orders as $order)
        {
            $order->shop = $this->shopRepo->find($order->shop_id);

            $listProduct =  $this->orderProductRepo->findByField('order_id', $order->id);
            if($listProduct !== null)
                foreach ($listProduct as $p)
                {
                    $t = $this->productRepo->find($p->product_id);
                    $p->product_key = $t->product_key;
                    $p->product_name = $t->product_name;
                    $p->resource = $t->resource;
                    $p->product_url = $t->product_url;
                    $p->thumbnails = $t->thumbnails;
                    $p->description = $t->description;
                }

            $order->products = $listProduct;
        }
        return array('status' => true, 'listOrder' => $orders);
    }

    public function viewOrder(Request $request)
    {
        $order = $this->orderRepo->findByField('id', $request['order_id'])->first();
        if($order == null) {
            return array('status' => false);
        }
        if($order->user_id != auth('users')->user()->id || $order->status == Order::STATUS_CART) {
            return array('status' => false);
        }
        $listProduct =  $this->orderProductRepo->findByField('order_id', $order->id);
        if($listProduct !== null)
            foreach ($listProduct as $p)
            {
                $t = $this->productRepo->find($p->product_id);
                $p->product_key = $t->product_key;
                $p->product_name = $t->product_name;
                $p->resource = $t->resource;
                $p->product_url = $t->product_url;
                $p->thumbnails = $t->thumbnails;
                $p->description = $t->description;
            }
        $order->shop = $this->shopRepo->find($order->shop_id);

        $order->comments = $this->commentRepo->findByField('order_id', $order->id);

        return array('status' => true, 'order' => $order, 'listProduct' => $listProduct);
    }

    public function cancelOrder(Request $request)
    {
        $order_id = $request['order_id'];

        $order  = $this->orderRepo->findByField('id', $order_id)->first();
        if($order === null) {
            return array('status' => false, 'message' => 'Something went wrong!');
        }
        if($order->status > Order::STATUS_AUTHENCATED) {
            return array('status' => false, 'message' => 'This order can\'t cancel!');
        }
        //find currently cart which is a order have status = 0
        $cart = $this->orderRepo->findWhere(['user_id' => auth('users')->user()->id, 'status' => Order::STATUS_CART])->first();
        if($cart === null) {
            //if not: create a cart
            $cart = $this->orderRepo->create([
                'user_id' => auth('users')->user()->id,
                'sum_price' => 0,
            ]);
        }

        $product_in_order = $this->orderProductRepo->findByField('order_id', $order_id);
        if($product_in_order->count())
            foreach($product_in_order as $p)
            {
                $this->orderProductRepo->update([
                    'order_id' => $cart->id
                ], $p->id);
            }
        if($order->status < Order::STATUS_AUTHENCATED) {
            $this->orderRepo->delete($order->id);
        } else {
            $this->orderRepo->update([
                'status' => Order::STATUS_CANCEL
            ],$order_id);
        }
        return array('status' => true);
    }

    public function comments(Request $request)
    {
        $order_id = $request['order_id'];
        $content = $request['content'];
        $order = $this->orderRepo->findByField('id', $order_id)->first();
        if(!$order) {
            return array('status' => false);
        }
        if($content == '' || $content == null) {
            return array('status' => false);
        }
        $user = auth('users')->user();
        if($order->user_id != $user->id) {
            return array('status' => false);
        }

        $comment = $this->commentRepo->create([
            'order_id' => $order->id,
            'type'     => 0,
            'content'  => $content
        ]);
        return array('status' => true, 'comment' => $comment);
    }

    public function getComments(Request $request)
    {
        $order_id = $request['order_id'];
        $comments = $this->commentRepo->findByField('order_id', $order_id);
        if(!$comments) {
            return array('status' => false);
        }
        return array('status' => true, 'comments' => $comments);
    }
}
