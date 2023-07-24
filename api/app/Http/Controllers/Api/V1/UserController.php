<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();

        return response()->json([
            'users' => $users,
            'message' => 'Users retrieved successfully.'
        ]);
    }

    public function show($userId)
    {
        $user = User::findOrFail($userId);

        $user->append('current_weather');

        return response()->json([
            'user' => $user,
            'message' => 'User retrieved successfully.'
        ]);
    }
}
