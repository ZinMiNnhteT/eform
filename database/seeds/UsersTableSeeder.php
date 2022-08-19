<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Ha Ha';
        $user->email = 'joyboy.mm@gmail.com';
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->phone = '09442627376';
        $user->password = Hash::make('123123123');
        $user->active = TRUE;
        $user->save();
    }
}
