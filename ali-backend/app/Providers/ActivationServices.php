<?php

namespace App\Providers;

use App\Repositories\AdminRepository;
use Carbon\Carbon;
use Mail;
use App\Mail\AdminActivationEmail;
use App\Entities\Admin;

class ActivationServices
{
    protected $resendAfter = 24; // Sẽ gửi lại mã xác thực sau 24h nếu thực hiện sendActivationMail()
    protected $admin;

    protected $adminRepo;

    public function __construct(Admin $admin, AdminRepository $adminRepo)
    {
        $this->admin = $admin;
        $this->adminRepo = $adminRepo;
    }

    public function sendActivationMail($admin)
    {
        $token = $this->adminRepo->createActivation($admin->id);
        $link = route('admin.activate', $token);
        $mailable = new AdminActivationEmail($link);
        Mail::to($admin->email)->send($mailable);
    }

    public function activateAdmin($token)
    {
        $admin = null;
        $admin = $this->adminRepo->findByField('remember_token', $token)->first();
        if($admin == null) return null;
        $admin->roles = 3;
        $admin->save();
        $this->adminRepo->update([
            'roles' => 3,
            'remember_token' => null,
            'updated_at' => new Carbon()
        ], $admin->id);
        return $admin;
    }

    private function shouldSend($admin)
    {
        return $admin === null || strtotime($admin->updated_at) + 60 * 60 * $this->resendAfter < time();
    }
}
