<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "admin";
        $user->email = "admin@gmail.com";
        $user->password = bcrypt("admin");
        $user->address = "Cầu giấy, Hà Nội";
        $user->phone = "0352359396";
        $user->avatar = "";
        $user->role = "Manager";
        $user->save();

        $user = new User();
        $user->name = "Chí Thành";
        $user->email = "chithanhvtpt@gmail.com";
        $user->password = bcrypt("123456");
        $user->address = "Cầu giấy, Hà Nội";
        $user->phone = "0352359396";
        $user->avatar = "";
        $user->role = "Manager";
        $user->save();

    }
}
