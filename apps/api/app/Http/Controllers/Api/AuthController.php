<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;

class AuthController extends Controller
{
    /**
     * @param AuthRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(AuthRegisterRequest $request)
    {
        $user = User::create([
            'email'    => $request->email,
            'password' => $request->password,
            'name' => $request->name,
        ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token, 201);
    }

    /**
     * @param AuthLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthLoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Wrong credencials'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @param string $token
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken(string $token, int $code = 200)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60
        ], $code);

    }
}