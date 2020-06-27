<?php

use Illuminate\Database\Seeder;
use App\Entities\Order;
use Carbon\Carbon;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $dt = Carbon::now();
        for($i = 1; $i <= 1000000 ; $i++) {
            Order::create([
                'user_id' => random_int(1,20),
                'shop_id' => random_int(1,10000),
                'status' => random_int(0,8),
                'created_at' => $dt->subDay(random_int(1,150))->toDateTimeString(),
                'updated_at' => $dt->subDay(random_int(1,150))->toDateTimeString(),
            ]);
            $dt = Carbon::now();
        }

    }
}
