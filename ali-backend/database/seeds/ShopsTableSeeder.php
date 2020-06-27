<?php

use App\Entities\Shop;
use Illuminate\Database\Seeder;

class ShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10000; $i++) {
            Shop::create([
                'name' => 'Shop' .$i,
                'email' => 'shop'.$i.'@gmail.com',
                'phone' => '0123456789',
                'address' => 'HN',
            ]);
        }
    }
}
