<?php

namespace App\Http\Controllers;


use App\Models\User;

class UserController extends Controller
{
    public function ban($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->is_banned = true;
            $user->save();
            return response()->json(['status' => 'success', 'message' => 'User banned']);
        }
        return response()->json(['status' => 'fail', 'message' => 'User not found'], 404);
    }
}
