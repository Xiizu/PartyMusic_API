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
            return response()->json(['statut' => 'success', 'message' => 'User successfully retrieved.', 'data' => $user]);
        }
    }

    function createUser(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = hash('sha256', $request->input('password'));
        if (!$name || !$email || !$password) {
            return response()->json(['statut' => 'error', 'message' => 'Name, Email and Password are required.'], 400);
        }
        $user = User::where('email', $email)->first();
        if ($user) {
            return response()->json(['statut' => 'error', 'message' => 'User already exists.'], 409);
        } else {
            $newUser = new User();
            $newUser->name = $name;
            $newUser->email = $email;
            $newUser->password = $password;
            $newUser->token = hash('sha256', $email . time() . $password);
            $newUser->save();
            return response()->json(['statut' => 'success', 'message' => 'User successfully created.', 'data' => $newUser], 201);
        }
    }

    function changeUsername(Request $request)
    {
        $id = $request->input('id');
        $newName = $request->input('name');
        if (!$id || !$newName) {
            return response()->json(['statut' => 'error', 'message' => 'User ID and new name are required.'], 400);
        }
        $user = User::find($id);
        if (!$user) {
            return response()->json(['statut' => 'error', 'message' => 'User not found.'], 404);
        } else {
            $user->name = $newName;
            $user->save();
            return response()->json(['statut' => 'success', 'message' => 'Username successfully changed.', 'data' => $user]);
        }
    }

    function changePassword(Request $request)
    {
        $id = $request->input('id');
        $oldPAssword = hash('sha256', $request->input('oldPassword'));
        $newPassword = hash('sha256', $request->input('password'));
        if (!$id || !$newPassword || !$oldPAssword) {
            return response()->json(['statut' => 'error', 'message' => 'User ID, old password and new password are required.'], 400);
        }
        $user = User::find($id);
        if (!$user) {
            return response()->json(['statut' => 'error', 'message' => 'User not found.'], 404);
        } else {
            if ($oldPAssword != $user->password) {
                return response()->json(['statut' => 'error', 'message' => 'Old password is incorrect.'], 403);
            } else if ($newPassword == $user->password) {
                return response()->json(['statut' => 'error', 'message' => 'New password cannot be the same as the old password.'], 417);
            } else {
                $user->password = $newPassword;
                $user->save();
                return response()->json(['statut' => 'success', 'message' => 'Password successfully changed.', 'data' => $user]);
            }
        }
    }
}