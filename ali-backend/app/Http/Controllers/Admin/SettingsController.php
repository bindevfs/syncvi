<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest\SettingRequest;
use App\Services\Admin\SettingService;

/**
 * Class SettingsController.
 *
 * @package namespace App\Http\Controllers;
 */
class SettingsController extends Controller
{
    /**
     * @var SettingService
     */
    protected $settingService;

    /**
     * SettingsController constructor.
     * @param SettingService $settingService
     */
    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function setting(SettingRequest $request)
    {
        if($request->ajax()) {
            $data = $this->settingService->setting($request);
            if($data['status']) {
                return json_encode(array('success' => true));
            }
            return json_encode(array('success' => false));
        }
        return json_encode(array('success' => false));
    }
}
