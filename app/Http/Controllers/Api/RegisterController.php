<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->only('name', 'email', 'desc', 'password', 'role');

        $validator = \Validator::make($data, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required',
        ]);

        $validator->validate();

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        return response()->json([
            'user' => $user
        ], 201);
    }
}
