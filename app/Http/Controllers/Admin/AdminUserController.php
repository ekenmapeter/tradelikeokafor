<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\WelcomeUser;
use App\Mail\NewUserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->with('activeSubscription.plan')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function show(User $user)
    {
        $user->load(['subscriptions.plan', 'transactions.plan']);
        return view('admin.users.show', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,admin',
        ]);

        $password = Str::random(10);
        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role' => $validated['role'],
            'password' => Hash::make($password),
            'status' => 'active',
        ]);

        // Send welcome email to user
        Mail::to($user->email)->send(new WelcomeUser($user, $password));

        // Send notification to admin
        $admin = User::where('role', 'admin')->where('id', '!=', $user->id)->first();
        if ($admin) {
            Mail::to($admin->email)->send(new NewUserRegistered($user));
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully. Welcome email sent with login credentials.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,admin',
            'status' => 'required|in:active,suspended',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function suspend(User $user)
    {
        $user->update(['status' => 'suspended']);

        return redirect()->back()
            ->with('success', 'User suspended successfully.');
    }

    public function activate(User $user)
    {
        $user->update(['status' => 'active']);

        return redirect()->back()
            ->with('success', 'User activated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->back()
                ->with('error', 'Cannot delete admin users.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
