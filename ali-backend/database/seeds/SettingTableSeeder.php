<?php

use App\Entities\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Setting::create([
            'key' => 'TG',
            'name' => 'Tỉ giá',
            'value' => 3500
        ]);
    }
}
