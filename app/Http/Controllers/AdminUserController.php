<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin,penulis',
        ]);

        $user->update([
            'role' => $request->role,
        ]);

        return back()->with('success', 'Role user berhasil diperbarui.');
    }
}