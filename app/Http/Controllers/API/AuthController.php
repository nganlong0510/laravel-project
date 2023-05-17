<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request): Response
    {
        $credentials = $request->validated();
        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if (!Auth::attempt($credentials, $remember)) {
            return response([
                'error' => 'The Provided credentials are not correct'
            ], 422);
        }
        $user = Auth::user();
        $token = Auth::user()?->createToken('main')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request): Response
    {
        /** @var User $user */
        $user = Auth::user();
        // Revoke the token that was used to authenticate the current request...
        $user->currentAccessToken()->delete();

        return response([
            'success' => true
        ]);
    }
}
