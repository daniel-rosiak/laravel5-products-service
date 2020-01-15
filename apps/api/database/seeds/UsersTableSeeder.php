<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('users')->get()->count() !== 0) {
            echo "\e[31mTable is not empty ";
            return;
        }

        User::create([
            'email'    => 'user@apptest.com',
            'password' => '123456',
            'name' => 'name'
        ]);


    }
}
