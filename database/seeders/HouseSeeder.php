<?php

namespace Database\Seeders;

use App\Models\House;
use Illuminate\Database\Seeder;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $house = new House();
        $house->name = "Vinhome Royal City";
        $house->address = "Thanh Xuân, Nguyễn Trãi";
        $house->bedroom = 2;
        $house->bathroom = 2;
        $house->description = "120m2 rộng rãi, thoáng mát, view đẹp";
        $house->price = 20000000;
        $house->status = "Có thể thuê";
        $house->category_id = 1;
        $house->user_id = 1;
        $house->save();
    }
}
