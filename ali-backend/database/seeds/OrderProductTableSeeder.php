<?php

use Illuminate\Database\Seeder;
use App\Entities\OrderProduct;
use App\Entities\Order;

class OrderProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $check[0][0] = 0;
        for($i = 1; $i <= 1000000; $i++) {
            $temp = random_int(1, 1000000);
            $order_id = random_int(1, 1000000);
            if(isset($check[$temp][$order_id])) {
                continue;
            }
            $price = random_int(1000, 1200)*1000;
            $quality = random_int(1,5);
            $check[$temp][$order_id] = 1;
            OrderProduct::create([
                'product_id' => $temp,
                'order_id' => $order_id,
                'quality' => $quality,
                'price' => $price,
            ]);
            $order = DB::table('orders')->where('id', $order_id)->first();
            $price = $order->sum_price + $price*$quality;
            if($order->status != 0 && $order->status < 7) {
                if($order->status >= 3) {
                    DB::table('orders')->where('id', $order->id)->update([
                        'sum_price' => $price,
                        'charge' => ((int) ($price * 0.035)/1000)*1000,
                        'deposit' => ((int) ($price * 1.035 * ((float)random_int(0,3)/10 + 0.6)/1000))*1000
                    ]);
                } else {
                    DB::table('orders')->where('id', $order->id)->update([
                        'sum_price' => $price,
                        'charge' => ((int) ($price * 0.035)/1000)*1000
                    ]);
                }
            }
        }

    }
}
