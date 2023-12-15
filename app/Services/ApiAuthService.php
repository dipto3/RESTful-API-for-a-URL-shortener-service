<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApiAuthService
{

    public function store($request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return $user;
    }

    public function login($request)
    {
        if (!Auth::attempt(request(['email', 'password']))) {
            return response()->json(['message' => 'Unauthorized User'], 401);
        }
        $token = $request->user()->createToken('Access token');
        return $token;
    }
}
