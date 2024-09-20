<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['email or password is wrong'],
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if ($user->is_admin) {
            $abilities = [
                'server:create',
                'server:read',
                'server:update',
                'server:delete',
            ];
        } else {
            $abilities = [
                'server:read',
            ];
        }

        $authToken = $user->createToken($request->email, $abilities)->plainTextToken;

        return ['token' => $authToken];
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }
}
