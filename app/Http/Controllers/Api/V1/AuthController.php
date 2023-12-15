<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\ApiAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $apiAuthService;
    public function __construct(ApiAuthService $apiAuthService)
    {
        $this->apiAuthService = $apiAuthService;
    }
    public function store(RegisterRequest $request)
    {
        $request->validated();
        $user =  $this->apiAuthService->store($request);

        return response()->json(['success' => true, 'user' => $user]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $token =  $this->apiAuthService->login($request);
        Cache::flush();
        return response()->json([
            'accessToken' => $token->plainTextToken,
        ]);
    }
}
