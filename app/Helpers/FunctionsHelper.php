<?php

namespace App\Helpers;

use App\Mail\DefaultMailer;
use App\Models\InsuranceEnquiry;
use App\Models\TwoWheelerInsurance;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class FunctionsHelper
{
    public static function login_user($request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['status' => false, 'data' => null, 'message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'true',
            'data' => [
                'token' => $token,
                'type' => 'bearer',
                'user' => $user,
            ]
        ]);
    }

    public static function apiData($data)
    {
        if (in_array('api', request()->route()->middleware())) {
            return $data;
        }
    }
}
