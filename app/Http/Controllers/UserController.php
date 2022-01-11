<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getAllHouse()
    {
        if (auth()->user()->role == "Manager") {
            $id = auth()->user()->id;
            $houses = House::with("category")->where("user_id", "=", $id)->get();
            return response()->json($houses);
        }else {
            return response()->json([
                'error' => "Fail",
                'massage' => "Not a manager"
            ]);
        }
    }
}
