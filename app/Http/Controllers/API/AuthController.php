<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if(! Auth::attempt($request->only('email','password')))
        {
            throw ValidationException::withMessages([
                'errorMessage' => 'Sorry, those credentials do not match.'
            ]);
        }

        $user = User::firstWhere('email',$request->email);
        $token = $user->createToken('access-token')->plainTextToken;
        return (new UserResource($user))->additional([
            'token' => $token,
        ]);   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return new UserResource($request->user());
    }
}
