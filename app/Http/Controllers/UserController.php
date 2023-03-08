<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    public function index()
    {
        // return User::orderBy('id', 'desc')->get();
        return User::orderBy('id', 'desc')->paginate();
    }

    public function show(User $user)
    {
        return $user;
    }

    public function store(UserCreateRequest $request)
    {
        $data = $request->all();

        $userFound = User::where('email', $data['email'])->count();

        if($userFound > 0) return response("Error, user already exists", Response::HTTP_CONFLICT);

        $data['password'] = Hash::make($data['password']);

        $user = User::Create($data);

        return response($user, Response::HTTP_CREATED);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->only('first_name', 'last_name', 'password');

        if(!empty($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }else{
            unset($data['password']);
        }

        $user->update($data);

        return response($user, Response::HTTP_ACCEPTED);
    }

    public function destroy(User $user)
    {
        $user->destroy($user->id);

        return response('', Response::HTTP_NO_CONTENT);
    }

    public function user()
    {
        return Auth::user();
    }
}
