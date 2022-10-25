<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SanctumController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $attributes = User::create($request->validated());
            return response()->json(UserResource::make($attributes), Response::HTTP_CREATED);
        } catch (\InvalidArgumentException $e) {
            return response()->json($e->getMessage());
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if( !$user || !Hash::check( $request->password, $user->password ) ) {
                throw ValidationException::withMessages( [
                    'email' => ['The provided credentials are incorrect.'],
                ] );
            }
            $token = $user->createToken( $request->device_name )->plainTextToken;
            return response()->json(['user' => UserResource::make($user), 'token' => $token]);
        } catch (\InvalidArgumentException $e) {
            return response()->json($e->getMessage());
        }
    }

    public function logout()
    {

    }

}
