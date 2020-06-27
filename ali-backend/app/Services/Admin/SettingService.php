<?php


namespace App\Services\Admin;

use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

class SettingService
{
    protected $settingRepo;

    public function __construct(SettingRepository $settingRepo)
    {
        $this->settingRepo = $settingRepo;
    }

    public function setting(Request $request)
    {
        $setting_id = $request['setting_id'];
        $rate = $request['rate'];
        $setting  = $this->settingRepo->findByField('id', $setting_id)->first();
        $this->settingRepo->update([
            'value' => $rate
        ], $setting_id);
        return array('status' => true, 'setting' => $setting);
    }

    public function viewSetting()
    {
        $setting = $this->settingRepo->findByField('key','TG')->first();
        return array('status' => true, 'setting' => $setting);
    }
}
