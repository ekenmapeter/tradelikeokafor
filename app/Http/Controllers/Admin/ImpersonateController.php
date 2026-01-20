<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImpersonateController extends Controller
{
    public function impersonate($userId)
    {
        $user = \App\Models\User::find($userId);

        if (! $user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        if ($user->isAdmin()) {
            return redirect()->back()->with('error', 'Cannot impersonate an admin.');
        }

        session()->put('impersonate', $user->id);

        return redirect()->route('user.dashboard');
    }

    public function leave()
    {
        if (! session()->has('impersonate')) {
            return redirect()->route('dashboard');
        }

        session()->forget('impersonate');

        return redirect()->route('admin.users.index');
    }
}
