<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        //$this->call(UsersTableSeeder::class);
        //$this->call(AdminsTableSeeder::class);
        //$this->call(ShopsTableSeeder::class);
        //$this->call(ShopUsersTableSeeder::class);
        //$this->call(SettingTableSeeder::class);
        //$this->call(OrderTableSeeder::class);
        //$this->call(ProductTableSeeder::class);
        $this->call(OrderProductTableSeeder::class);
        $this->call(GalleryTableSeeder::class);
    }
}
