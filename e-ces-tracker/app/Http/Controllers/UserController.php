<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('users.index', [
            'users' => $users,
            'totalUsers' => User::count(),
            'systemAdminsCount' => User::where('role', User::ROLE_SUPER_ADMIN)->count(),
            'adminsCount' => User::where('role', User::ROLE_ADMIN)->count(),
        ]);
    }
}
