<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = User::create([
                'name' => $request->name, // Change 'username' to 'name'
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 2,  // Default role_id
            ]);

     

            return response()->json([
                'message' => 'Registration successful.',
          
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred during registration.'], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials.'], 401);
        }
    
        $user = Auth::user();
        $token = $user->createToken('GeStockToken')->plainTextToken;
    
        return response()->json([
            'message' => 'Login successful.',
            'token' => $token,
            'user' => $user
        ], 200);
    }
    
    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            $user->tokens()->where('id', $request->tokenId)->delete();
        
            return response()->json(['message' => 'Logout successful.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred during logout.'], 500);
        }
    }
    
    
    
}
