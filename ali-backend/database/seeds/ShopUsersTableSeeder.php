<?php

use App\Entities\ShopUser;
use Illuminate\Database\Seeder;

class ShopUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 100000; $i++) {
            ShopUser::create([
                'name'            =>  'shopuser'.$i,
                'email'           =>  'shopuser'.$i.'@gmail.com',
                'shop_id'         =>  random_int(1,10000),
                'password'        =>  bcrypt('shopuser12345'),
                'phone'           =>  '012345678'.$i,
            ]);
        }
    }
}
