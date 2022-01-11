<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    public function register(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email",
            "password" => "required|min:6|max:12",
            "repassword" => "required|min:6|max:12",
            "phone" => "required",
            "address" => "required",
            "role" => "required",
        ]);
        $data = $request->only("name", "email", "password", "repassword", "phone", "address", "avatar", "role");
        if ($request->password == $request->repassword) {
            $data["password"] = bcrypt($request->password);
            $user = User::query()->create($data);
            return response()->json([
                "message" => "Register Successful",
                "user" => $user
            ]);
        }else {
            return response()->json([
                "error" => "Can't not register",
                "message" => "Your password and your repassword not same!"
            ]);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);
        $data = $request->only("email", "password");
        if ($token = Auth::attempt($data)) {
            return $this->createNewToken($token);
        }else {
            return response()->json([
                "error" => "Something wrong",
                "message" => "Account not exits!"
            ]);
        }
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Signed out successfully']);
    }





    public function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

}
