<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function getOrder($id, Request $request)
    {
        $houseId = House::with("user", "category", "images")->find($id);
        $userId = auth()->user()->id;
        $order = new Order();
        $order->start_date = $request->start_date;
        $order->end_date = $request->end_date;
        $order->house_id = $id;
        $order->user_id = $userId;
        $order->price = $houseId->price;
        $order->status = "Đang chờ duyệt";
        $order->save();
        $house = House::with("user")->where("id", "=", $id)->get();
        return response()->json([
           "order" => $order,
           "house" => $house
        ]);
    }
//    public function houseRent($id, Request $request, Order $order): \Illuminate\Http\JsonResponse
//    {
//        $date = $this->dateDifference($request->start_date, $request->end_date);
//        $user = auth()->user();
//        $house = House::with('user')->find($id);
//        $email = $house->user->email;
//        $content = 'order';
//        $orders = Order::where('status', '=', 'Xác nhận')->where('house_id', '=', $id)->get();
//        $house_id = [];
//        foreach ($orders as $ord) {
//            if (
//                ($request->start_date >= $ord->start_date && $request->start_date <= $ord->end_date) ||
//                ($request->end_date >= $ord->start_date && $request->end_date <= $ord->end_date) ||
//                ($ord->start_date <= $request->end_date && $ord->start_date >= $request->start_date) ||
//                ($ord->end_date <= $request->end_date && $ord->end_date >= $request->start_date)
//            ) {
//                if ($user->id != $house->user_id) {
//                    $house_id[] = $ord->house_id;
//                }
//            }
//        }
//        if (!array_unique($house_id) && $house->status == 'còn trống') {
//            $order->user_id = $user->id;
//            $order->house_id = $id;
//            $order->start_date = $request->start_date;
//            $order->end_date = $request->end_date;
//            $order->total_price = (int)($date * $house->price);
//            $order->status = 'chờ xác nhận';
//            $order->save();
//            (new MailController)->sendMail($email, $content);
//            return response()->json(['success' => 'Ok', $user]);
//        } elseif ($house->status == 'đang nâng cấp') {
//            return response()->json(['message' => 'Nhà đang được nâng cấp'], 403);
//        } else {
//            return response()->json(['message' => 'nhà đang cho thuê'], 403);
//        }
//    }

    //chu nha xac nhan thue nha

    public function rentConfirm($id, $value)
    {
        define('CONFIRM', 'xác nhận');
        define('DENIED', 'không xác nhận');
        $order = Order::with('user')->find($id);
        $email = $order->user->email;
        if ($value == CONFIRM) {
            $content = 'approved';
            $order->status = $value;
            $order->save();
            (new MailController)->sendMail($email, $content);
            return response()->json(['success' => 'bạn đã xác nhận']);
        }
        if ($value == DENIED) {
            $content = 'not approved';
            $order->status = $value;
            $order->save();
            (new MailController)->sendMail($email, $content);
            return response()->json(['error' => 'bạn đã hủy xác nhận']);
        }
        return response()->json(['message' => 'bạn không thực hiện được thao tác này']);
    }

    // lịch sử thuê nhà của một khách

    public function rentHistory()
    {
        $id = auth()->user()->id;
        $user = User::find($id);
        $orders = Order::with('house')->where('user_id', $id)->OrderBy('create_at', 'DESC')->get();
        $data = ['user' => $user, 'order' => $orders];
        return response()->json($data);
    }


    // hủy thuê nhà

    public function cancelRent($id)
    {
        $order = Order::find($id);
        $rent_date = date('Y-m-d', strtotime("-2 day", strtotime($order->start_date)));
        $date = date('Y-m-d');
        $content = 'cancel';
        if ($date <= $rent_date) {
            if ($order->status == 'xác nhận') {
                $order->status = 'đã hủy';
                $order->save();
                $house = House::with('user')->find($order->house_id);
                $email = $house->user->email;
                (new MailController)->sendMail($email, $content);
                return response()->json(['success' => 'bạn đã hủy thuê']);
            }
            if ($order->status == 'chờ xác nhận') {
                $order->status = 'đã hủy';
                $order->save();
                $house = House::with('user')->find($order->house_id);
                $email = $house->user->email;
                (new MailController)->sendMail($email, $content);
                return response()->json(['success' => 'bạn đã hủy đơn thuê']);
            }
            return response()->json(['error' => 'ban chỉ phép hủy trước một ngày']);
        }
    }


    //lấy ra được 5 căn nhà thuê nhiều nhất

    public function autoUpdate()
    {
        $date = date('Y-m-d');
        $orders = Order::with('house', 'user')->get();
        foreach ($orders as $order) {
            if ($order->status == 'xác nhận' && $date >= $order->start_date) {
                $house = House::find($order->house->id);
                $house->status = 'đã cho thuê';
                $house->save();
            }
            if ($order->status == 'xác nhận' && $date < $order->start_date) {
                $house = House::find($order->house->id);
                if (!$house->status == 'đã cho thuê') {
                    $house->status = 'còn trống';
                    $house->save();
                }
            }
            if ($order->status == 'xác nhận' && $date > $order->end_date){
                $order->status = 'đã thanh toán';
                $order->save();
                $house = House::find($order->house->id);
                $house->status = 'còn trống';
                $house->save();
            }
            if ($order->status == 'xác nhận' && $date > $order->end_date){
                $order->status = 'đã thanh toán ';
                $order->save();
                $house = House::find($order->house->id);
                $house->status= 'còn trống';
                $house->save();
            }
            if ($order->status == 'chờ xác nhận' && $date >= $order->start_date) {
                $order->status = 'không xác nhận';
                $order->save();
            }
            $rentMost = Order::select('house_id', DB::raw('count(id) as count'))
                ->with('house', 'image')
                ->where('status', '=' ,'đã thanh toán')
                ->groupBy('house_id')
                ->orderBy('count','DESC')
                ->limit(5)->get();
            return response()->json($rentMost);
        }
    }

    //lịch sử thuê nhà của môt ngôi nhà

    public function rentHistoryHouse($id)
    {
        $house = House::find($id);
        if (auth()->user()->role == 'manager' && auth()->user()->id == $house->user_id) {
            $orders = Order::with('user', 'house')->where('house_id', '=', $id)->get();
            return response()->json($orders);
        }
    }




}
