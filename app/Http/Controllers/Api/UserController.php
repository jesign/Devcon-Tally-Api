<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function logout()
    {
        try {
            $user = \Auth::user();

            if ($user) {
                $user->oauthAccessToken()->delete();
            }

            return 'true';
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
