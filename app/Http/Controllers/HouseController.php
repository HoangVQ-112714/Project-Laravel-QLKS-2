<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Image;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    public function index(): JsonResponse
    {
        $houses = House::with('user', 'category', 'images')->get();
        return response()->json($houses);
    }

    public function detail($id): JsonResponse
    {
        $house = House::with('user', 'category', 'images')->find($id);
        return response()->json($house);
    }


    //tao mot can nha
    public function create(Request $request, House $house): JsonResponse
    {
        $user = User::find($request->user_id);
        if ($user->role == 'Manager') {
            $house->user_id = $request->user_id;
            $house->name = $request->name;
            $house->category_id = $request->category_id;
            $house->address = $request->address;
            $house->bedroom = $request->bedroom;
            $house->bathroom = $request->bathroom;
            $house->description = $request->description;
            $house->price = $request->price;
            $house->status = "Có thể cho thuê";
            $house->save();
        }
//        for ($i = 0; $i < count($request->images); $i++) {
//            $image = new Image();
//            $image->name = $house->name . ' - ' . ($i + 1);
//            $image->house_id = $house->id;
//            $image->url = $request->iamge[$i];
//            $image->save();
//        }
        return response()->json(['success' => 'Đăng nhà thành công']);
    }

    //tim kiem mot ngoi nha


    public function search(Request $request)
    {
        $name = $request->input("search");
//        $address = $request->search;
        $houses = House::with("category", "images", "user")
            ->where("name", "like", "%". $name . "%")
//            ->where("address", "like", "%{$address}%")
            ->get();
        return response()->json($houses);
    }

    public function delete($id)
    {
        $house = House::with( "user", "category")->find($id);
        $house->delete();
        return response()->json([
            "message" => "ok"
        ]);
    }

    public function edit(Request $request ,$id)
    {
        House::query()->findOrFail($id);
        $data = $request->only('name','address','bedroom', "bathroom",'description','price','status','category_id','user_id');
        $house = House::query()->where("id", '=',$id)->update($data);
        return response()->json($house);
    }



//    public function search($start_date, $end_date, $bedroom, $bathroom, $price_min, $price_max, $address)
//    {
//        if (isset($_GET["start_date"])) {
//            dd($_GET["start_date"]);
//        }
//        $house_id = [];
//        $orders = Order::where('status', '=', 'xác nhận1')->get();
//        foreach ($orders as $order) {
//            if (
//                ($start_date >= $order->start_date && $start_date <= $order->end_date) ||
//                ($end_date >= $order->start_date && $end_date <= $order->end_date) ||
//                ($order->start_date <= $end_date && $order->start_date >= $start_date) ||
//                ($order->end_date <= $end_date && $order->end_date >= $start_date)
//            ) {
//                $house_id[] = $order->house_id;
//            }
//        }
//        $houses = House::with('category', 'user', 'images')
//            ->whereNotIn('id', array_unique($house_id))
//            ->where('price', '>=', $price_min)
//            ->where('price', '<=', $price_max)
//            ->orwhere('bedroom', '=', $bedroom)
//            ->orwhere('bathroom', '=', $bathroom)
//            ->where('address', 'LIKE', '%' . $address . '%')->get();
//        return response()->json($houses);
//    }
}
