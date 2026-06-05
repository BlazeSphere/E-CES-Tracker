<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Display a listing of the audit logs.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $isSuperAdmin = $user->role === 0;

        $query = AuditLog::with('user')->latest();

        // Super Admin can filter by user
        if ($isSuperAdmin && $request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $logs = $query->paginate(20);
        $users = $isSuperAdmin ? \App\Models\User::orderBy('name')->get() : collect();

        return view('audit-logs.index', compact('logs', 'users', 'isSuperAdmin'));
    }
}
