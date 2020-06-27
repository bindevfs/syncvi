<?php

namespace App\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OrderRepository;
use App\Entities\Order;
use App\Validators\OrderValidator;

/**
 * Class OrderRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return OrderValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function allOrderUser($user_id)
    {
        return Order::where('user_id', $user_id)->where('status', '>', 0)->whereNull('deleted_at');
    }

    public function findOrderForShop($shop_id)
    {
        return Order::where('shop_id', $shop_id)->where('status', '>', 0)->orderBy('id','desc');
    }

    public function findNewOrderForShop($shop_id)
    {
        return Order::where('shop_id', $shop_id)->where('status', Order::STATUS_PROCESSING)->orderBy('id','desc');
    }

    public function findAuthenticatedOrderForShop($shop_id)
    {
        return Order::where('shop_id', $shop_id)->where('status', Order::STATUS_AUTHENCATED)->orderBy('id','desc');
    }

    public function countOrderForShop($shop_id)
    {
        return (Order::where('shop_id',$shop_id)->where('status', '>', 0)->get())->count();
    }

    public function countOrderForUser($user_id)
    {
        return (Order::where('user_id',$user_id)->where('status', '>', 0)->get())->count();
    }

    public function searchOrder($role, $search,$shop,$price1,$price2,$date1,$date2,$sort,$perpage, $page)
    {

        if($price1 == '' || $price1 == null) {
            $price1 = 0;
        }
        if($price2 == '' || $price2 == null) {
            $price2 = 92233720368547;
        }
        if($date1 == '' || $date1 == null) {
            $temp = new Carbon('first day of January 2010');
            $date1 = $temp->toDateString();
        }
        if($date2 == '' || $date2 == null) {
            $temp = Carbon::now();
            $temp->addYear();
            $date2 = $temp->toDateString();
        }
        if($role == '0' || $role == '' || $role == null) {
            $role1 = '> 0';
        } else {
            $role1 = 'IN (';
            $cc = 0;
            foreach ($role as $r)
            {
                if($cc == 1) $role1 = $role1.',';
                $role1 = $role1.$r;
                $cc = 1;
            }
            $role1 = $role1.')';
        }
        if($sort == '' || $sort == null) {
            return Order::select('orders.id','orders.user_id','orders.sum_price','orders.charge','orders.payment','orders.deposit','orders.shop_id','orders.status','users.name','users.phone')
                ->join('users','users.id','=','orders.user_id')
                ->whereRaw('`orders`.`status` '.$role1.' AND (`users`.`name` LIKE \'%'.$search.'%\' OR `users`.`phone` LIKE \'%'.$search.'%\')')
                ->where('orders.shop_id','=',$shop)->orderBy('id','desc')->whereBetween('orders.created_at', [$date1, $date2])->whereBetween('orders.sum_price', [$price1, $price2])
                ->offset($perpage*($page-1))->limit($perpage)->get();
        }
        return Order::select('orders.id','orders.user_id','orders.sum_price','orders.charge','orders.payment','orders.deposit','orders.shop_id','orders.status','users.name','users.phone')
            ->join('users','users.id','=','orders.user_id')
            ->whereRaw('`orders`.`status` '.$role1.' AND (`users`.`name` LIKE \'%'.$search.'%\' OR `users`.`phone` LIKE \'%'.$search.'%\')')
            ->where('orders.shop_id','=',$shop)->whereBetween('orders.created_at', [$date1, $date2])->whereBetween('orders.sum_price', [$price1, $price2])
            ->orderBy('sum_price', $sort)
            ->offset($perpage*($page-1))->limit($perpage)->get();
    }

    public function calChartForShop($shop_id)
    {
        $day = Carbon::now()->toDateString();
        $orders = DB::table('orders')->where('created_at', '>=', $day)
            ->select(DB::raw('SUM(sum_price) as price'), DB::raw('SUM(charge) as sum_charge'))
            ->where('shop_id', $shop_id)->where('status', Order::STATUS_FINISH)->groupBy('shop_id')->get();
        $temp = Order::select('*')->where('created_at', '>=', $day)->where('shop_id', $shop_id)->where('status', Order::STATUS_FINISH)->get();
        foreach ($orders as $order)
            return array('sum_price' => $order->price, 'sum_charge' => $order->sum_charge, 'num_orders' => $temp->count());
        return array('sum_price' => 0, 'sum_charge' => 0, 'num_orders' => 0);
    }

    public function chartOrder($shop_id, $option)
    {
        if($option == 'today') {
            $day = Carbon::now();
        } else if($option == 'seven') {
            $day = Carbon::now()->subDays(7);
        } else if($option == 'month') {
            $day = Carbon::now()->subDays(30);
        } else if($option == 'month_ago') {
            $day = (Carbon::now()->subDays(30))->subDays(30);
        }
        $orders = DB::table('orders')->where('shop_id', $shop_id)->where('status', Order::STATUS_FINISH)->groupBy('shop_id')
            ->where('created_at', '>=', $day)->groupBy('date')->orderBy('date', 'ASC')
            ->get([DB::raw('Date(created_at) as date'),  DB::raw('SUM(sum_price) as sum_price')])
            ->toJson();
        return $orders;
    }

    public function removeProductForOrder($product_id)
    {
        return Order::where('product_id', '=', $product_id)->delete();
    }
}
