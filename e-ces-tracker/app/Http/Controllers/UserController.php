<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Ensure UI values like 'Deactivated' map correctly to the database 'inactive' state
        if (strtolower($request->input('status')) === 'deactivated') {
            $request->merge(['status' => 'inactive']);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'role' => 'required|integer|in:0,1',
            'status' => 'required|string|in:active,inactive',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status' => $validated['status'],
            'password' => Hash::make($validated['password']),
        ]);

        AuditLog::create([
            'user_id' => Auth::id() ?? $user->id,
            'action' => 'User Created',
            'description' => "Created new user: {$user->email}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        // Ensure UI values like 'Deactivated' or 'Disabled' map correctly to the database 'inactive' state
        $statusInput = strtolower($request->input('status'));
        if (in_array($statusInput, ['deactivated', 'disabled'])) {
            $request->merge(['status' => 'inactive']);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email:rfc,dns|unique:users,email,{$user->id}",
            'role' => 'required|integer|in:0,1',
            'status' => 'required|string|in:active,inactive',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status' => $validated['status'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'User Updated',
            'description' => "Updated user: {$user->email}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }
}
