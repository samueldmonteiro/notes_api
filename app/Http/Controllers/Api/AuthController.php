<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:50',
            'password' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return $this->json([
                'error' => $validator->errors(),
                'message' => $validator->errors()->first()
            ], 422);
        }
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return $this->json(['error' => 'Authentication failure'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return $this->json(['me' => auth()->user()]);
    }

    public function logout()
    {
        auth()->logout();
        return $this->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}
