<?php

namespace App\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProductRepository;
use App\Entities\Product;
use App\Validators\ProductValidator;

/**
 * Class ProductRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProductRepositoryEloquent extends BaseRepository implements ProductRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ProductValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    public function allBuilder()
    {
        return Product::where('id','>',0);
    }

    public function newProduct()
    {
        return Product::whereRaw('DATEDIFF(CURDATE(), created_at) <= 31');
    }

    public function whereIn($col, $arr)
    {
        $products = Product::whereIn($col, $arr);
        return $products;
    }

    public function searchProduct($shop_id, $search, $price1, $price2, $date1, $date2, $perpage, $page)
    {
        if($price1 == '' || $price1 == null) {
            $price1 = 0;
        }
        if($price2 == '' || $price2 == null) {
            $price2 = 92233720368547;
        }
        if($date1 == '' || $date1 == null) {
            $temp = new Carbon('first day of January 2010');
            $date1 = $temp->toDateTimeString();
        }
        if($date2 == '' || $date2 == null) {
            $temp = Carbon::now();
            $temp->addYear();
            $date2 = $temp->toDateTimeString();
        }
        return Product::where('products.shop_id','=',$shop_id)->whereBetween('products.created_at', [$date1, $date2])->whereBetween('products.sell_price', [$price1, $price2])
            ->whereRaw('`products`.`product_name` LIKE \'%'.$search.'%\' OR `products`.`product_key` LIKE \'%'.$search.'%\'')
            ->offset($perpage*($page-1))->limit($perpage)->get();
    }

    public function chartProduct($shop_id, $option)
    {
        $products = Product::where('shop_id', $shop_id)->get();
        if($option == 'price') {
            $option = 'price';
        } else if($option == 'quality') {
            $option = 'quality';
        }
        foreach ($products as $product)
        {
            $day = Carbon::now()->subDays(30);
            $product->chart = DB::table('products')->where('products.id', $product->id)->join('order_products','products.id', '=', 'order_products.product_id')
                ->where('order_products.created_at', '>=', $day)
                ->select(DB::raw('SUM(order_products.'.$option.') as '.$option.''))->get();
        }
        return $products;
    }

    public function allProduct($shop_id)
    {
        $products = Product::where('shop_id', $shop_id)->get();
        foreach ($products as $product)
        {
            $product->gallery = DB::table('galleries')->where('product_id', $product->id)->get();
        }
        return $products;
    }
}
