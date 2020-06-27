<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ShopRepository;
use App\Entities\Shop;
use App\Validators\ShopValidator;

/**
 * Class ShopRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ShopRepositoryEloquent extends BaseRepository implements ShopRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Shop::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ShopValidator::class;
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
        return Shop::where('id','>',0);
    }

    public function newShop()
    {
        return Shop::whereRaw('DATEDIFF(CURDATE(), created_at) <= 31');
    }

    public function searchShop($role, $search, $sort, $option, $perpage, $page)
    {
        $Shop = Shop::select('shops.id','shops.name','shops.email','shops.phone','shops.address','shops.deleted_at',''.$option.'.shop_id')
            ->join(''.$option.'', 'shops.id', '=' , ''.$option.'.shop_id')->groupBy('shops.id');
        $role = (int) $role;
        if($role == 1) {
            $role = '`shops`.`deleted_at` IS NULL AND ';
        } else if($role == 2) {
            $role = '`shops`.`deleted_at` IS NOT NULL AND ';
        } else $role = '';
        if ($option == 'shop_users') {
            $query_option = '';
        } else {
            $query_option = 'AND `orders`.`status` > 0';
        }
        $Shop->orderByRaw('(SELECT COUNT(`'.$option.'`.`shop_id`) FROM `'.$option.'` WHERE `'.$option.'`.`shop_id` = `shops`.`id` '.$query_option.') '.$sort.'')
            ->whereRaw($role.'(`shops`.`name` LIKE \'%'.$search.'%\' OR `shops`.`phone` LIKE \'%'.$search.'%\' OR `shops`.`email` LIKE \'%'.$search.'%\')');
        return $Shop->offset($perpage*($page-1))->limit($perpage)->get();
    }
}
