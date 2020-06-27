<?php

namespace App\Repositories\Eloquent;

use Carbon\Carbon;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AdminRepository;
use App\Entities\Admin;
use App\Validators\AdminValidator;

/**
 * Class AdminRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AdminRepositoryEloquent extends BaseRepository implements AdminRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Admin::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return AdminValidator::class;
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
        return Admin::where('id', '>', 0);
    }

    public function newAdmin()
    {
        return Admin::whereRaw('DATEDIFF(CURDATE(), created_at) <= 31');
    }

    public function getToken()
    {
        $length = 40;
        try {
            $length = 20 + random_int(0, 40);
        } catch (\Exception $e) {
        }
        return hash_hmac('sha256', str_random($length), config('app.key'));
    }

    public function createActivation($id)
    {
        $token = $this->getToken();
        while($this->findByField('remember_token', $token)->count())
        {
            $token = $this->getToken();
        }
        Admin::where('id', $id)->update([
            'remember_token' => $token,
            'updated_at' => new Carbon()
        ]);
        return $token;
    }

    public function searchAdmin($search, $role, $perpage, $page )
    {
        return Admin::whereRaw('`roles` LIKE \'%'.$role.'%\' AND (`name` LIKE \'%'.$search.'%\' OR `phone` LIKE \'%'.$search.'%\' OR `email` LIKE \'%'.$search.'%\')')
            ->offset($perpage*($page-1))->limit($perpage)->get();
    }
}
