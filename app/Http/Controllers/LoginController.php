<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;

class LoginController extends Controller
{
    public function check(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required','confirmed'],

        ]);
        //  only for laravel view
        // if (Auth::attempt($credentials)) {
        //     // return redirect()->route('welcome');
        //     return redirect()->route('tasks.store');
        // }

        // return response()->json([
        //     'status' => false,
        //     'message' => "Fail",
        // ]);
        if (Auth::attempt($credentials)) {
            return response()->json([
                'status' => true,
                'message' => 'Login successful',
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Login failed',
        ]);

    }
}

