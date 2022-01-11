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
            $house->name = 'nha A';
            $house->address = 'ha noi';
            $house->bedroom = '3';
            $house->bathroom = '3';
            $house->description = 'rat to';
            $house->price='2000';
            $house->status = '1';
            $house->category_id = '1';
            $house->user_id = '1';
            $house->save();
    }
}
