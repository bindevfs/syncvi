<?php

use App\Entities\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 5; $i++)
        {
            Admin::create([
                'name' => 'superadmin'.$i,
                'email' => 'superadmin'.$i.'@gmail.com',
                'password' => bcrypt('superadmin'),
                'phone' => '0123456789',
                'roles' => 1,
            ]);
        }
        for($i = 1; $i <= 5; $i++)
        {
            Admin::create([
                'name' => 'admin'.$i,
                'email' => 'admin'.$i.'@gmail.com',
                'password' => bcrypt('admin12345'),
                'phone' => '0123456789',
                'roles' => 2,
            ]);
        }
        for($i = 1; $i <= 10; $i++)
        {
            Admin::create([
                'name' => 'order'.$i,
                'email' => 'order'.$i.'@gmail.com',
                'password' => bcrypt('order12345'),
                'phone' => '0123456789',
                'roles' => 3,
            ]);
        }
    }
}
