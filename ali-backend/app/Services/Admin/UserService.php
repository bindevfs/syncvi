<?php


namespace App\Services\Admin;


use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserService
{
    protected $userRepo;

    protected $orderRepo;

    public function __construct(UserRepository $userRepo, OrderRepository $orderRepo)
    {
        $this->userRepo = $userRepo;
        $this->orderRepo = $orderRepo;
    }

    public function manageUser()
    {
        $users = $this->userRepo->allBuilder()->paginate(10);
        foreach ($users as $user)
        {
            $user->numberOrder = $this->orderRepo->countOrderForUser($user->id);
        }
        return array('status' => true, 'users' => $users);
    }

    public function manageNewUser()
    {
        $newusers = $this->userRepo->newUser()->paginate(10);
        foreach ($newusers as $newuser)
        {
            $newuser->numberOrder = $this->orderRepo->countOrderForUser($newuser->id);
        }
        return array('status' => true, 'newusers' => $newusers);
    }

    public function disableUser(Request $request)
    {
        if($request['user_id']) {
            $user_id = $request['user_id'];
            $user = $this->userRepo->find($user_id);
            if($user->deleted_at == null) {
                $data = [
                    'deleted_at' => Carbon::now(),
                ];
            }
            else {
                $data = [
                    'deleted_at' => null,
                ];
            }
            $this->userRepo->update($data,$user->id);
            return array('status' => true, 'user' => $user);
        }
    }

    public function filterUser(Request $request)
    {
        $sort = $request['sort'];
        $role = $request['role'];
        $search = $request['search'];
        $perpage = $request['perpage'];
        $page = $request['page'];
        $data = $this->userRepo->searchUser($role,$search,$sort,$perpage,$page);
        while ($data->count() == 0 && $page > 1) {
            $page--;
            $data = $this->userRepo->searchUser($role,$search,$sort,$perpage,$page);
        }
        $total_row = $data->count();
        if($total_row > 0) {
            foreach ($data as $user)
            {
                $user->numberOrder = $this->orderRepo->countOrderForUser($user->id);
            }
            $output = view('admin.users.render')->with('users', $data)->render();
        } else {
            $output = '<h2>Not found</h2>';
        }
        $data = array(
            'page_current' => $page,
            'table_data' => $output,
            'total_data' => $total_row
        );
        return array('status' => true, 'data' => $data);
    }
}
