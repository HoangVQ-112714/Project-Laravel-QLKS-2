<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function houseRent($id , Request $request, Order $order)
    {
        $date = $this->dateDifference($request->start_date , $request->end_date);
        $user = auth()->user();
        $house = House::with('user')->find($id);
        $email = $house->user->email;
        $content = 'order';
        $orders = Order::where('status' , '=' , 'xác nhận')->where('house_id', '=',$id)->get();
        $house_id = [];
        foreach ($orders as $ord){
            if (
                ($request->start_date >= $ord->start_date && $request->start_date <= $ord->end_date) ||
                ($request->end_date >= $ord->start_date && $request->end_date <= $ord->end_date) ||
                ($ord->start_date <= $request->end_date && $ord->start_date >= $request->start_date) ||
                ($ord->end_date <= $request->end_date && $ord->end_date >= $request->start_date)
            ){
                if ($user->id != $house->user_id){
                    array_push($house_id,$ord->house_id);
                }
            }
        }
        if (!array_unique($house_id) && $house->status == 'còn trống'){
            $order->user_id  = $user->id;
            $order->house_id = $id;
            $order->start_date = $request->start_date;
            $order->end_date = $request->end_date;
            $order->total_price = (int)($date * $house->price);
            $order->status = 'chờ xác nhận';
        }
    }
}
