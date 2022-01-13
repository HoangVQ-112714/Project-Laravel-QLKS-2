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
        $house->status = "Có thể cho thuê";
        $house->category_id = 1;
        $house->image="https://cdn.luxstay.com/users/22959/pu1oVWjsZpJSKR5yAdO1pn3Q.jpeg";
        $house->user_id = 1;
        $house->save();

        $house = new House();
        $house->name = "Chillin House Sunny";
        $house->address = "Thanh Xuân, Nguyễn Trãi";
        $house->bedroom = 2;
        $house->bathroom = 2;
        $house->description = "Oceanview Superior Apartment - 120m2 rộng rãi, thoáng mát, view đẹp";
        $house->price = 829000;
        $house->status = "Có thể thuê";
        $house->category_id = 1;
        $house->image="https://cdn.luxstay.com/rooms/20935/large/room_20935_21_1550755657.jpg";
        $house->user_id = 1;
        $house->save();

        $house = new House();
        $house->name = "Sa House - Melody";
        $house->address = "Thanh Xuân, Nguyễn Trãi";
        $house->bedroom = 2;
        $house->bathroom = 1;
        $house->description = "Cozy and Sweety - 120m2 rộng rãi, thoáng mát, view đẹp";
        $house->price = 400000;
        $house->status = "Có thể thuê";
        $house->category_id = 1;
        $house->image="https://cdn.luxstay.com/users/22959/pu1oVWjsZpJSKR5yAdO1pn3Q.jpeg";
        $house->user_id = 1;
        $house->save();

        $house = new House();
        $house->name = "The Avis Apartment";
        $house->address = "Hà Đông";
        $house->bedroom = 1;
        $house->bathroom = 2;
        $house->description = "Attic Double 401 - 1 Phòng tắm · 1 giường · 1 phòng ngủ · 2 khách (tối đa 2 khách)";
        $house->price = 595000;
        $house->status = "Có thể thuê";
        $house->category_id = 1;
        $house->image="https://cdn.luxstay.com/users/22959/pu1oVWjsZpJSKR5yAdO1pn3Q.jpeg";
        $house->user_id = 1;
        $house->save();

        $house = new House();
        $house->name = "TITAN 01";
        $house->address = "Đống Đa";
        $house->bedroom = 3;
        $house->bathroom = 2;
        $house->description = "Luxury homestay - Nguyên căn · 2 Phòng tắm · 2 giường · 2 phòng ngủ · 6 khách (tối đa 10 khách)";
        $house->price = 20000000;
        $house->status = "Có thể thuê";
        $house->category_id = 1;
        $house->image="https://cdn.luxstay.com/users/301105/rfvYyD17hmliHGP2CbigaqTN.jpg";
        $house->user_id = 1;
        $house->save();

        $house = new House();
        $house->name = "ECOSTAY SEAVIEW";
        $house->address = "Đống Đa";
        $house->bedroom = 1;
        $house->bathroom = 2;
        $house->description = "Nguyên căn · 1 Phòng tắm · 2 giường · 2 phòng ngủ · 4 khách (tối đa 6 khách)";
        $house->price = 500000;
        $house->status = "Có thể thuê";
        $house->category_id = 1;
        $house->image="https://cdn.luxstay.com/users/139439/ErCKg_UUeOT2EXJqNWpOGtyW.JPG";
        $house->user_id = 1;
        $house->save();

        $house = new House();
        $house->name = "VILLA DE BLANC";
        $house->address = "Hoàn Kiếm";
        $house->bedroom = 4;
        $house->bathroom = 9;
        $house->description = "Nguyên căn · 4 Phòng tắm · 9 giường · 5 phòng ngủ · 15 khách (tối đa 25 khách)";
        $house->price = 3000000;
        $house->status = "Có thể thuê";
        $house->category_id = 1;
        $house->image="https://cdn.luxstay.com/users/400427/AJrpZirqdVtOE9a9uwC4hR0x.jpg";
        $house->user_id = 1;
        $house->save();
    }
}
