<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;

class SanctumController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $attributes = User::create($request->validated());
            return response()->json('user created success.');
        } catch (\InvalidArgumentException $e) {
            return response()->json($e->getMessage());
        }
    }

    public function login()
    {

    }

    public function logout()
    {

    }

}
