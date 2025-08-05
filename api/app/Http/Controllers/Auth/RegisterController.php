<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2',
            'email' => 'required|string|email|unique:users',
            'password' => ['required', 'min:1']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $user = User::factory()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password'=>Hash::make($request->password)
        ]);
        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;

        return response()->json([
            "user" => new ProfileResource($user),
            'token' => $token,
        ]);
    }
}
