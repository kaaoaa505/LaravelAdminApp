<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::attempt(request()->only('email', 'password'))) {
            $user = Auth::user();

            $token = $user->createToken('admin')->accessToken;

            $cookie = cookie('jwt', $token, 3600);

            return  response(compact('token'))->withCookie($cookie) ;
        }

        $error = 'Invalid Credentials';

        return response(compact('error'), Response::HTTP_UNAUTHORIZED);
    }

    public function logout()
    {
        $cookie = cookie()->forget('jwt');

        $message = 'success';

        return  response(compact('message'))->withCookie($cookie) ;
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->all();

        $userFound = User::where('email', $data['email'])->count();

        if($userFound > 0) return response("Error, user already exists", Response::HTTP_CONFLICT);

        $data['password'] = Hash::make($data['password']);

        $user = User::Create($data);

        return response($user, Response::HTTP_CREATED);
    }
}
