<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ManageUserController extends Controller
{
    public function manageUsers(Request $request)
    {
        $users = User::all();

        // Check if the current user has permission to manage users
        if (Gate::allows('manage-users')) {
            return view('manage-users', compact('users'));
        }

        // Redirect the user if they don't have permission
        return redirect()->route('home')->with('error', 'You are not authorized to manage users.');
    }

    public function approve(User $user)
    {
        $user->approve();

        return redirect()->route('manage-users')->with('success', 'User approved successfully.');
    }

    public function pend(User $user)
    {
        $user->pend();

        return redirect()->route('manage-users')->with('success', 'User status changed to pending.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('manage-users')->with('success', 'User deleted successfully.');
    }
}
