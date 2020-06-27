<?php

namespace App\Services\Shop\Order;

use App\Notifications\OrderNoti;
use App\Repositories\CommentRepository;
use App\Repositories\OrderProductRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ShopRepository;
use App\Repositories\ShopUserRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Entities\Order;
use Illuminate\Support\Facades\Notification;

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
     * @var OrderProductRepository
     */
    protected $orderProductRepo;

    /**
     * @var ShopUserRepository
     */
    protected $shopUserRepo;

    /**
     * @var ShopRepository
     */
    protected $shopRepo;

    /**
     * @var CommentRepository
     */
    protected $commentRepo;

    /**
     * OrderService constructor.
     * @param UserRepository $userRepo
     */
    public function __construct(OrderRepository $orderRepo, ProductRepository $productRepo, ShopRepository $shopRepo,
                                OrderProductRepository $orderProductRepo, UserRepository $userRepo, ShopUserRepository $shopUserRepo, CommentRepository $commentRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->productRepo = $productRepo;
        $this->orderProductRepo = $orderProductRepo;
        $this->userRepo = $userRepo;
        $this->shopUserRepo = $shopUserRepo;
        $this->shopRepo = $shopRepo;
        $this->commentRepo = $commentRepo;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function newOrder(Request $request)
    {
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if(!$user) {
            return array('status' => false);
        }
        $listOrder = $this->orderRepo->findNewOrderForShop($user->shop_id)->paginate(10);
        if($listOrder)
            foreach ($listOrder as $order)
            {
                $order->user = $this->userRepo->find($order->user_id);
            }
        return array('status' => true, 'listOrder' => $listOrder);
    }

    public function authenticatedOrder(Request $request)
    {
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if(!$user) {
            return array('status' => false);
        }
        $listOrder = $this->orderRepo->findAuthenticatedOrderForShop($user->shop_id)->paginate(10);
        if($listOrder)
            foreach ($listOrder as $order)
            {
                $order->user = $this->userRepo->find($order->user_id);
            }
        return array('status' => true, 'listOrder' => $listOrder);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function authenticateOrder(Request $request)
    {
        $order = $this->orderRepo->findByField('id', $request['order_id'])->first();
        if($order === null) {
            return array('status' => false);
        }
        if( ($order->sum_price + $order->charge) - $order->deposit/Order::PERCENT_DEPOSIT_MIN > 5000) {
            return array('status' => false);
        }
        if(($order->sum_price*1000 + $order->charge*1000) == 0) $temp = 0;
        else $temp = ($order->deposit*1000) / ($order->sum_price*1000 + $order->charge*1000);
        if($temp >= (Order::PERCENT_DEPOSIT_MIN * 1000) ) {
            $order = $this->orderRepo->update([
                'status' => Order::STATUS_PAID
            ], $order->id);
        } else {
            $order = $this->orderRepo->update([
                'status' => Order::STATUS_AUTHENCATED
            ], $order->id);
        }
        return array('status' => true);
    }

    public function rejectOrder(Request $request)
    {
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if(!$user) {
            return array('status' => false);
        }
        $order = $this->orderRepo->findByField('id', $request['order_id'])->first();
        if($order === null) {
            return array('status' => false);
        }
        if($order->deposit == 0) {
            $order = $this->orderRepo->update([
                'status' => Order::STATUS_CANCEL
            ], $order->id);
        } else {
            $order = $this->orderRepo->update([
                'status' => Order::STATUS_REQUIRE_REJECT
            ], $order->id);
        }
        $shopuser = $this->shopUserRepo->findByField('shop_id', $user->shop_id);
        Notification::send($shopuser, new OrderNoti($user, $order, 'reject order'));
        return array('status' => true, 'order' => $order);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function allOrder(Request $request)
    {
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if(!$user) {
            return array('status' => false);
        }
        $listOrder = $this->orderRepo->findOrderForShop($user->shop_id)->paginate(10);
        $count = $this->orderRepo->findOrderForShop($user->shop_id)->count();
        if($listOrder)
            foreach ($listOrder as $order)
            {
                $order->user = $this->userRepo->find($order->user_id);
            }
        return array('status' => true, 'listOrder' => $listOrder, 'count' => $count);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function viewOrder(Request $request)
    {
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if(!$user) {
            return array('status' => false);
        }
        $order = $this->orderRepo->find($request['order_id']);
        if($order === null) {
            return array('status' => false);
        }
        if($order->shop_id !== $user->shop_id) {
            return array('status' => false);
        }
        $listProduct =  $this->orderProductRepo->findByField('order_id', $order->id);
        $comment = $this->commentRepo->findByField('order_id', $order->id);
        $user = $this->userRepo->find($order->user_id);
        if($order->status == 1) {
            $day = Carbon::now();
            $delivery_date = ($day->addDays(10));
            $order = $this->orderRepo->update([
                'delivery_date' => $delivery_date,
            ], $order->id);
        }
        if($listProduct !== null)
            foreach ($listProduct as $p)
            {
                $t = $this->productRepo->find($p->product_id);
                $p->product_key = $t->product_key;
                $p->product_name = $t->product_name;
                $p->resource = $t->resource;
                $p->product_url = $t->product_url;
                $p->thumbnails = $t->thumbnails;
            }
        return array('status' => true, 'order' => $order, 'listProduct' => $listProduct,'user' => $user,'comment' => $comment );
    }

    public function updateOrder(Request $request)
    {
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if(!$user) {
            return array('status' => false);
        }
        $order = $this->orderRepo->find($request['order_id']);
        if($order === null) {
            return array('status' => false);
        }
        if($order->shop_id !== $user->shop_id) {
            return array('status' => false);
        }
        $note = isset($request['note']) ? $request['note'] : $order->note;
        $deposit = isset($request['deposit']) ? $request['deposit'] : $order->deposit;
        if(isset($request['status'])) {
            $this->continueOrder($request);
        }
        $order = $this->orderRepo->update([
            'note' => $note,
            'deposit' => $deposit,
        ], $order->id);
        if ($order->status === Order::STATUS_AUTHENCATED) {
            $products = $this->orderProductRepo->findByField('order_id', $order->id);
            foreach ($products as $product)
            {
                $product_id = $request['product_id'];
                if(isset($product_id) === $product->id) {
                    $order = $this->orderRepo->removeProductForOrder($product_id);
                }
            }
        }
        $shopuser = $this->shopUserRepo->findByField('shop_id', $user->shop_id);
        Notification::send($shopuser, new OrderNoti($user, $order, 'update order'));
        return array('status' => true, 'order' => $order);
    }

    public function filterOrder(Request $request)
    {
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if(!$user) {
            return array('status' => false);
        }
        $shop = $user->shop_id;
        $search = $request['search'];
        $role = $request['role'];
        $price1 = $request['price1'];
        $price2 = $request['price2'];
        $date1 = $request['date1'];
        $date2 = $request['date2'];
        $sort = $request['sort'];
        $perpage = isset($request['perpage']) ? $request['perpage'] : 10;
        $page = isset($request['page']) ? $request['page'] : 1;
        if($shop == null) {
            return array('status' => false);
        }
        $data = $this->orderRepo->searchOrder($role,$search,$shop,$price1,$price2,$date1,$date2,$sort,$perpage, $page);
        if($data)
            foreach ($data as $order)
            {
                $order->user = $this->userRepo->find($order->user_id);
            }
        while ($data->count() == 0 && $page > 1) {
            $page--;
            $data = $this->orderRepo->searchOrder($role,$search,$shop,$price1,$price2,$date1,$date2,$sort,$perpage, $page);
            if($data)
                foreach ($data as $order)
                {
                    $order->user = $this->userRepo->find($order->user_id);
                }
        }
        $total_row = $data->count();
        return array('status' => true, 'page_current' => $page, 'orders' => $data, 'total_data' => $total_row);
    }

    public function continueOrder(Request $request)
    {
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if(!$user) {
            return array('status' => false);
        }
        $temp = $this->orderRepo->findByField('id',$request['order_id'])->first();
        if($temp === null) {
            return array('status' => false);
        }
        if($temp->shop_id !== $user->shop_id) {
            return array('status' => false);
        }
        if($temp->status === Order::STATUS_REQUIRE_REJECT || $temp->status === Order::STATUS_FINISH || $temp->status === Order::STATUS_CANCEL || $temp->status === Order::STATUS_ORTHER) {
            return array('status' => false);
        }

        if($temp->status === Order::STATUS_CART) {
            $temp->charge = $temp->deposit * Order::PERCENT_CHARGE;
            $temp->charge /= 1000;
            $temp->charge *= 1000;
        }

        if($temp->status === Order::STATUS_AUTHENCATED) {
            if( ($temp->sum_price + $temp->charge) - $temp->deposit/Order::PERCENT_DEPOSIT_MIN > 5000) {
                return array('status' => false);
            }
            $data = Carbon::now();
            $temp->delivery_date = ($data->addDays(10));
        }

        if($temp->status === Order::STATUS_SHIPPING) {
            $temp->deposit = $temp->sum_price + $temp->charge;
            $temp->delivery_date = Carbon::now();
        }

        $order = $this->orderRepo->update([
            'status'        => $temp->status + 1,
            'charge'        => $temp->charge,
            'deposit'       => $temp->deposit,
            'created_at'    => $temp->created_at,
            'delivery_date' => $temp->delivery_date
        ], $temp->id);
        $shopuser = $this->shopUserRepo->findByField('shop_id', $user->shop_id);
        Notification::send($shopuser, new OrderNoti($user, $order, 'continue order'));
        return array('status' => true, 'order' => $order);
    }

    public function chartForShopToday(Request $request)
    {
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if(!$user) {
            return array('status' => false);
        }
        $orders = $this->orderRepo->calChartForShop($user->shop_id);
        return array('status' => true, 'orders' => $orders);
    }

    public function chartOrder(Request $request)
    {
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if(!$user) {
            return array('status' => false);
        }
        $option = $request['option'];
        if($option === null) {
            return array('status' => false);
        }
        $orders = $this->orderRepo->chartOrder($user->shop_id, $option);
        return array('status' => true, 'orders' => $orders);
    }

    public function chartProduct(Request $request)
    {
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if(!$user) {
            return array('status' => false);
        }
        $option = $request['option'];
        if($option === null) {
            return array('status' => false);
        }
        $products = $this->productRepo->chartProduct($user->shop_id, $option);
        return array('status' => true, 'products' => $products);
    }

    public function createOrder(Request $request)
    {
        $shop = auth('web_shop_users')->user();
        if(!$shop) {
            $shop = auth('shop_users')->user();
        }
        if(!$shop) {
            return array('status' => false);
        }
        $data = json_decode($request->getContent(), true);
        $phone = $data['phone'];
        $user = $this->userRepo->findByField('phone', $phone)->first();
        if($user === null) {
            return array('status' => false, 'message' => 'Khách hàng không tồn tại. Thực hiện đăng ký tài khoản cho khách hàng.');
        }
        $list_product = $data['list_product'];
        $description = isset($data['description']) ? $data['description'] : '';
        $note = isset($data['note']) ? $data['note'] : '';
        $deposit = isset($data['deposit']) ? $data['deposit'] : '';
        $payment = isset($data['payment']) ? $data['payment'] : '';
        $delivery_date = isset($data['delivery_date']) ? $data['delivery_date'] : Carbon::now()->toDateString();

        $sum = 0;
        if(empty($list_product)) {
            return array('status' => false, 'message' => 'Không có sản phẩm trong đơn hàng.');
        }
        $order = $this->orderRepo->create([
            'user_id' => $user->id,
            'description' => $description,
            'status' => Order::STATUS_PROCESSING,
            'note' => $note,
        ]);
        if(is_array($list_product)) {
            for ($i = 0; $i < count($list_product); $i++) {
                $temp = $this->productRepo->findWhere(['id'=> $data['list_product'][$i]['product_id'], 'shop_id' => $shop->shop_id])->first();
                if($temp === null) {
                    return array('status' => false, 'message' => 'error');
                }
                $order_product = $this->orderProductRepo->create([
                    'order_id' => $order->id,
                    'product_id' => $data['list_product'][$i]['product_id'],
                    'quality' => $data['list_product'][$i]['quality'],
                    'price' => $temp->sell_price,
                ]);
                $sum += ($data['list_product'][$i]['quality'] * $temp->sell_price);
            }
        }
        /// charge 3.5%
        $charge = ((int)((float) $sum*Order::PERCENT_CHARGE)/1000) * 1000;

        //finish
        $order = $this->orderRepo->update([
            'sum_price' => $sum,
            'charge' => $charge,
            'created_at' => Carbon::now()->toDateTimeString(),
            'delivery_date' => $delivery_date,
            'deposit' => $deposit,
            'payment' => $payment
        ], $order->id);
        $shopuser = $this->shopUserRepo->findByField('shop_id', $shop->shop_id);
        Notification::send($shopuser, new OrderNoti($shop, $order, 'create order'));
        return array('status' => true, 'order' => $order);
    }

    public function noti()
    {
        $shop = auth('web_shop_users')->user();
        if(!$shop) {
            $shop = auth('shop_users')->user();
        }
        if(!$shop) {
            return array('status' => false);
        }
        $notis = $shop->notifications()->get();
        return array('status' => true, 'notifications' => $notis);
    }

    public function fixDatabase(Request $request)
    {
        $orders = $this->orderRepo->all();
        foreach ($orders as $order)
        {
            $t = new Carbon($order->created_at);
            $this->orderRepo->update([
                'note' => ($t->addDays(10))->toDateString()
            ], $order->id);
        }
    }

    public function vnpay(Request $request)
    {
        session(['cost_id' => $request->id]);
        session(['url_prev' => url()->previous()]);
        $vnp_TmnCode = "WDMUV7FB"; //Mã website tại VNPAY
        $vnp_HashSecret = "FHKLXLGSMYEVDKGPZXXNPQGWOJFBTOTN"; //Chuỗi bí mật
        $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:8001/api/shop/returnPay";
        $vnp_TxnRef = $request['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $order = $this->orderRepo->findByField('id', $vnp_TxnRef)->first();
        $vnp_OrderInfo = "Thanh toán đơn hàng";
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $order->sum_price + $order->charge;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }
        return array('status' => true, 'vnp_url' => $vnp_Url);
    }

    public function returnPay(Request $request)
    {
        if($request['vnp_ResponseCode'] == '00') {
            $orderId = $request['vnp_TxnRef'];
            $order = $this->orderRepo->findByField('id', $orderId)->first();
            if ($order == null) {
                return array('status' => false);
            }
            $order = $this->orderRepo->update([
                'deposit' => $order->sum_price + $order->charge,
                'status' => Order::STATUS_PAID,
            ], $orderId);
            return array('status' => true, 'order' => $order);
        }
        return array('status' => false);
    }
}
