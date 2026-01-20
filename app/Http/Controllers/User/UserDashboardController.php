<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $activeSubscription = $user->activeSubscription;
        $recentTransactions = $user->transactions()->latest()->take(5)->get();

        return view('user.dashboard', compact('user', 'activeSubscription', 'recentTransactions'));
    }
}
