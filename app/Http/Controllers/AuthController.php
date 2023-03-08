<?php

namespace App\Http\Controllers;

use Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::attempt(request()->only('email', 'password'))) {
            $user = Auth::user();

            $token = $user->createToken('admin')->accessToken;

            return compact('token');
        }

        $error = 'Invalid Credentials';

        return response(compact('error'), Response::HTTP_UNAUTHORIZED);
    }
}
