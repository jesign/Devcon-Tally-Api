<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()) {
            return response()->json([
                'user' => auth()->user()
            ], 200);
        }
        
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout()
    {
        try {
            if (auth()->user()) {
                auth()->user()->token()->delete();
            }

            return 'true';
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getJudges(){
        return User::judges()->get();
    }

    public function saveJudge(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $user = $request->id ? User::find($request->id) : new User;
        $data = $request->all();

        $data['roles'] = 'judge';
        $data['password'] = Hash::make($data['password']);
        $user->fill($data);
        $user->save();

        return $user;
    }
}
