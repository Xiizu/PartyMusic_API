<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function loginUser(Request $request)
    {
        $email = $request->input('email');
        $password = hash('sha256', $request->input('password'));
        $user = User::where('email', $email)->first();

        if (!$email || !$password) {
            return response()->json(['statut' => 'error', 'message' => 'Password and Email are required.'], 400);
        }
        if (!$user) {
            return response()->json(['statut' => 'error', 'message' => 'Username or Password incorrect.'], 404);
        } else {
            if ($password != $user->password) {
                return response()->json(['statut' => 'error', 'message' => 'Username or Password incorrect.'], 403);
            } else {
                return response()->json(['statut' => 'success', 'message' => 'User successfully connected.','data' => $user], 200);
            }
        }
    }

    function getUser(Request $request)
    {
        $id = $request->input('id');
        if (!$id) {
            return response()->json(['statut' => 'error', 'message' => 'User ID is required.'], 400);
        }
        $user = User::find($id);
        if (!$user) {
            return response()->json(['statut' => 'error', 'message' => 'User not found.'], 404);
        } else {
            return response()->json(['statut' => 'success', 'message' => 'User successfully retrieved.', 'user' => $user]);
        }
    }
}