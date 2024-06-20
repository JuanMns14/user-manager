<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    /**
     * Register API
     *
     * @return \Illuminate\Http\Response
     */
    public function register(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->attach(1);
        return $this->sendResponse($user, "Accout created successfully", 201);
    }

    /**
     * Login API
     *
     * @return \Illuminate\Http\Response
     */
    public function login(AuthRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->password, $user->password)) {
            return $this->sendError("Invalid login credentials", [], 401);
        };

        $abilities = [];
        if ($user->roles()->find(1)) {
            $abilities = [
                'user:index',
                'user:show',
                'user:store',
                'user:update',
                'user:destroy',
            ];
        } else if ($user->roles()->find(2)) {
            $abilities = [
                'user:index',
                'user:show',
            ];
        }

        $response = [
            'user' => $user,
            'token' => $user->createToken('auth_token', $abilities)->plainTextToken,
        ];

        return $this->sendResponse($response, "Login successfully", 200);
    }

    /**
     * Logout API
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse([], "Logout successfully", 200);
    }
}
