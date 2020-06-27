<?php

use App\Entities\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dt = Carbon::now();
        for($i = 1; $i <= 20; $i++)
        {
            User::create([
                'name'            =>  'user'.$i,
                'email'           =>  'user'.$i.'@gmail.com',
                'password'        =>  bcrypt('user12345'),
                'phone'           =>  '012345678'.$i,
                'address'         =>  'DN',
                'created_at' => $dt->subDay(random_int(1,150))->toDateTimeString(),
                'updated_at' => $dt->subDay(random_int(1,150))->toDateTimeString(),
            ]);
            $dt = Carbon::now();
        }
    }
}
