<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserRepository;
use App\Entities\User;
use App\Validators\UserValidator;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return UserValidator::class;
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
        return User::where('id','>',0);
    }

    public function newUser()
    {
        return User::whereRaw('DATEDIFF(CURDATE(), created_at) <= 31');
    }

    public function searchUser($role, $search, $sort, $perpage, $page)
    {
        $User = User::select('users.id','users.name','users.email','users.email','users.phone','users.address','users.deleted_at','orders.user_id','orders.status')
            ->join('orders', 'users.id', '=' , 'orders.user_id')->groupBy('users.id')
            ->orderByRaw('(SELECT COUNT(`orders`.`user_id`) FROM `orders` WHERE `orders`.`user_id` = `users`.`id` AND `orders`.`status` > 0) '.$sort.'');
        $role = (int) $role;
        if($role == 1) {
            $role = '`users`.`deleted_at` IS NULL AND';
        } else if ($role == 2) {
            $role = '`users`.`deleted_at` IS NOT NULL AND';
        } else $role = '';
        $User->whereRaw($role.'(`users`.`name` LIKE \'%'.$search.'%\' OR `users`.`phone` LIKE \'%'.$search.'%\' OR `users`.`email` LIKE \'%'.$search.'%\')');
        return $User->offset($perpage*($page-1))->limit($perpage)->get();
    }
}
