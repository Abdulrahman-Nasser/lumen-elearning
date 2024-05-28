<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function store(Request $request)
    {
        // Use the Validator facade for validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'password' => "required|max:8|confirmed"
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'errors' => $validator->errors()
            ], 422);
        }

        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        User::create($input);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully, login now'
        ]);
    }

    public function login(Request $request)
    {
        // Use the Validator facade for validation
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => "required|max:8"
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::whereEmail($request->email)->first();
        if (!is_null($user) && Hash::check($request->password, $user->password)) {
            $user->api_token = str()->random(80);
            $user->api_key = str()->random(100);
            $user->save();

            return response()->json([
                "status" => "success",
                'token' => $user->api_token,
                "api_key" => $user->api_key,
                'message' => 'Logged in successfully'
            ])->header('Authorization', 'Bearer ' . $user->api_token);

        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Wrong email or password'
            ]);
        }
    }
}
