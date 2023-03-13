<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserInfoUpdateRequest;
use App\Http\Requests\UserPasswordUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Auth;
use Gate;

class UserController extends Controller
{
    public function index()
    {
        Gate::authorize('view', 'users');

        $users = User::with('role')->orderBy('id', 'desc')->paginate();
        return UserResource::collection($users);
    }

    public function show($id)
    {
        Gate::authorize('view', 'users');

        $user = User::with('role')->find($id);
        return (new UserResource($user))->additional([
            'data' => [
                'permissions' => $user->permissions()
            ]
        ]);
    }

    public function store(UserCreateRequest $request)
    {
        Gate::authorize('edit', 'users');

        $data = $request->only('first_name', 'last_name', 'email', 'password', 'role_id');

        $userFound = User::where('email', $data['email'])->count();

        if ($userFound > 0) return response("Error, user already exists", Response::HTTP_CONFLICT);

        $data['password'] = Hash::make($data['password']);

        $user = User::Create($data);

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        Gate::authorize('edit', 'users');

        $data = $request->only('first_name', 'last_name', 'password', 'role_id');

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if (empty($data['role_id'])) unset($data['role_id']);

        $user->update($data);

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    public function destroy(User $user)
    {
        Gate::authorize('edit', 'users');

        $user->destroy($user->id);

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function user()
    {
        Gate::authorize('view', 'users');

        return new UserResource(Auth::user());
    }

    public function userInfoUpdate(UserInfoUpdateRequest $request)
    {
        $user = Auth::user();

        $data = $request->only('first_name', 'last_name');

        $user->update($data);

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    public function userPasswordUpdate(UserPasswordUpdateRequest $request)
    {
        $user = Auth::user();

        $data = $request->only('password');

        $data['password'] = Hash::make($data['password']);

        $user->update($data);

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }
}
