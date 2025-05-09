<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\Doctor;
use App\Http\Resources\DoctorResource;
class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }
    public function store(UserRequest $request)
    {
        $user = User::create($request->only('name', 'email', 'password', 'phone', 'role'));
        if ($user->role === 'doctor') {
            $doctor = Doctor::create([
                'user_id' => $user->id,
                'specialty' => $request->specialty
            ]);
            return response()->json([
                'message' => 'Doctor created successfully',
                'user' => new DoctorResource($doctor)
            ], 201);
        }
        return response()->json(['message' => 'User created successfully', 'user' => new UserResource($user)], 201);
    }
    public function show(User $user)
    {
        return new UserResource($user);
    }
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->all());
        return response()->json(['message' => 'User updated successfully', 'user' => new UserResource($user)], 200);
    }
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
