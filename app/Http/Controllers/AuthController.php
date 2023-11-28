<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isJson()) {
            $validator = Validator::make($request->all(), [
                'email'    => 'required|email|exists:users,email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ])->setStatusCode(422);
            }

            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'The provided credentials are incorrect.',
                ])->setStatusCode(401);
            }

            Auth::login($user, $request->remember ? true : false);

            $token = $user->createToken('larachat')->plainTextToken;

            return response()->json([
                'status'       => true,
                'message'      => 'Successfully logged in.',
                'access_token' => $token,
            ])->setStatusCode(200);
        }

        return view('auth.login', [
            'title' => 'Sign In',
        ]);
    }
}
