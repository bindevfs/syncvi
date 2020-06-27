<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ShopUserRepository;
use App\Entities\ShopUser;
use App\Validators\ShopUserValidator;

/**
 * Class ShopUserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ShopUserRepositoryEloquent extends BaseRepository implements ShopUserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ShopUser::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ShopUserValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function countShopUser($shop_id)
    {
        return (ShopUser::where('shop_id', $shop_id)->get())->count();
    }

    public function allBuilder($shop_id)
    {
        return ShopUser::where('shop_id','=',$shop_id);
    }

    public function newShopUser($shop_id)
    {
        return ShopUser::where('shop_id','=',$shop_id)->whereRaw('DATEDIFF(CURDATE(), created_at) <= 31');
    }
}
