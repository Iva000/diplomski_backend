<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'gender' => 'required|string|max:255',
                'phoneNumber' => 'required|string|max:255',
                'email' => 'required|string|max:255|email|unique:users',
                'password' => 'required|string|min:5'
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }


        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'gender' => $request->gender,
            'phoneNumber' => $request->phoneNumber,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now()
        ]);


        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['success' => 'true', 'response' => 'You have been successfully registerd!', 'created_user' => new UserResource($user), 'access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate(
            [
                'name' => '',
                'surname' => '',
                'phoneNumber' => '',
            ]
        );

        $user = User::find($request->id);
        $user->update($validatedData);

        return response()->json(['success' => 'true', 'response' => 'You have successfully changed your information!']);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['success' => 'false']);
        }

        $user = User::where('email', $request['email'])->first();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['success' => 'true', 'access_token' => $token, 'token_type' => 'user', 'user' => $user]);
    }

    public function logout()
    {

        auth()->user()->tokens()->delete();

        return response()->json(['response' => 'Logged out!']);
    }

    public function getUser($id)
    {
        $user = User::where('id', $id)->get();

        return response()->json(['user' => $user]);
    }
}
