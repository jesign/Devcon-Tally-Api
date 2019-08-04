<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
