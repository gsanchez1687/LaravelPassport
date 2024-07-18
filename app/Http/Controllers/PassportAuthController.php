<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PassportAuthController extends Controller
{
    //agregar el codigo de store de Laravel Breeze
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

       $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->accessToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    public function login(Request $request){

        $credentials = request([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if(auth()->attempt($credentials)){
            $token = auth()->user()->createToken('auth_token')->plainTextToken;
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 200);
        }else{
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    public function logout(Request $request){
        $token = auth()->user()->token();
        $token->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }
}
