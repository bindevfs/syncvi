<?php


namespace App\Services\Admin;

use App\Entities\Admin;
use App\Providers\ActivationServices;
use App\Repositories\AdminRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminService
{
    protected $adminRepo;

    protected $activationService;

    public function __construct(AdminRepository $adminRepo, ActivationServices $activationService)
    {
        $this->adminRepo = $adminRepo;
        $this->activationService = $activationService;
    }

    public function loginAdmin(Request $request)
    {
        $arr = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        $admin = $this->adminRepo->findByField('email',$request->email)->first();
        if (Auth::guard('admin')->attempt($arr)) {
            return array('status' => true, 'admin' => $admin);
        } else return array('status' => false, 'admin' => $admin);
    }

    public function registerAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8',
            're-password' => 'required|same:password',
        ]);
        if($validator->fails())
        {
            return response()->json($validator->errors());
        }
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->phone = $request->phone;
        $admin->save();
        $admin_data = array('name' => $request->get('name'),'email' => $request->get('email'),'password' => $request->get('password'),'phone'=>$request->get('phone'));
        $this->activationService->sendActivationMail($admin);
        return array('status' => true);
    }

    public function activateAdmin($token)
    {
        $admin = null;
        $admin = $this->activationService->activateAdmin($token);
        if($admin!=null)
        {
            Auth::guard('admin')->login($admin);
            return array('status' => true);
        }
        abort(404);
    }

    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
    }

    public function manageAdmin()
    {
        $admins = $this->adminRepo->allBuilder()->paginate(10);
        return array('status' => true,'admins' => $admins);
    }

    public function manageNewAdmin()
    {
        $newadmins = $this->adminRepo->newAdmin()->paginate(10);
        return array('status' => true,'newadmins' => $newadmins);
    }

    public function deleteAdmin(Request $request)
    {
        if($request['admin_id']) {
            $this->adminRepo->delete($request['admin_id']);
            return array('status' => true);
        }
    }

    public function filterAdmin(Request $request)
    {
        $search = $request['search'];
        $role = $request['role'];
        $perpage = $request['perpage'];
        $page = $request['page'];
        $data = $this->adminRepo->searchAdmin($search, $role,$perpage, $page);
        while ($data->count() == 0 && $page > 1) {
            $page--;
            $data = $this->adminRepo->searchAdmin($search, $role,$perpage, $page);
        }
        $total_row = $data->count();
        if($total_row > 0) {
            $output = view('admin.admins.render')->with('admins', $data)->render();
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
