<?php

use Illuminate\Database\Seeder;
use App\Entities\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i = 1; $i <= 1000000; $i++)
            Product::create([
                'product_key' => str_random(3).random_int(100,999).$i,
                'product_name' => str_random(16),
                'resource' => 'tmall',
                'sell_price' => random_int(10000,100000),
                'product_url' => 'https://chaoshi.detail.tmall.com/item.htm?id=585792892201&spm=875.7931836/B.2017039.5.340f4265YloBOq&scm=1007.12144.81309.73136_0_0&pvid=fd538341-42fa-4545-ab3c-d8efb1ce84eb&utparam=%7B%22x_hestia_source%22:%2273136%22,%22x_object_type%22:%22item%22,%22x_mt%22:8,%22x_src%22:%2273136%22,%22x_pos%22:2,%22x_pvid%22:%22fd538341-42fa-4545-ab3c-d8efb1ce84eb%22,%22x_object_id%22:585792892201%7D',
                'shop_id' => random_int(1,10000),
            ]);
    }
}
