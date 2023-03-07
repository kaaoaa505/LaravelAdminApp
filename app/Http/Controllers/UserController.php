<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show(User $user)
    {
        return $user;
    }

    public function store()
    {
        $userFound = User::where('email', request()->input('email'))->count();

        if($userFound > 0) return response("Error, user already exists", Response::HTTP_CONFLICT);

        $user = User::Create([
            'first_name' => request()->input('first_name'),
            'last_name' => request()->input('last_name'),
            'email' => request()->input('email'),
            'password' => Hash::make(request()->input('password')),
        ]);
        return response($user, Response::HTTP_CREATED);
    }

    public function update(User $user)
    {
        $user->update([
            'first_name' => request()->input('first_name'),
            'last_name' => request()->input('last_name'),
            'email' => request()->input('email'),
            'password' => Hash::make(request()->input('password')),
        ]);

        return response($user, Response::HTTP_ACCEPTED);
    }

    public function destroy(User $user)
    {
        $user->destroy($user->id);

        return response('', Response::HTTP_NO_CONTENT);
    }
}
