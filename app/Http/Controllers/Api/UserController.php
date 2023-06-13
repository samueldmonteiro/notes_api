<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\NoteResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->json([
            'message' => 'All users',
            'users' => UserResource::collection(User::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = User::make($request->validated());
        $user->password = Hash::make($request->password);
        $user->save();

        $token = auth()->login($user);
        return $this->json([
            'message' => 'User created successfully',
            'user' => new UserResource($user),
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        if (!$user = User::find($id)) {
            return $this->json(['error' => 'User not found', 'user' => null], 404);
        }

        if (auth()->id() !== $user->id) {
            return $this->json(['error' => 'Unauthorized'], 401);
        }

        return $this->json([
            'message' => 'User found',
            'user' => new UserResource($user),
            'notes' => NoteResource::collection($user->notes()->get())
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
