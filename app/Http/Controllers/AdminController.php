<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_employees' => User::where('role', 'employee')->count(),
            'total_clients' => User::where('role', 'client')->count()
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function manageUsers(): View
{
    $users = User::orderByRaw("CASE WHEN role = 'admin' THEN 0 ELSE 1 END")->paginate(10);
    return view('admin.manage-users', compact('users'));
}

public function create(): View
{
    return view('admin.users.create');
}

public function store(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|string|in:admin,employee,client', // Validate role
    ]);

    try {
        // Attempt to create the user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Ensure role is set
        ]);

        return redirect()->route('dashboard')->with('success', 'User created successfully.');
    } catch (\Exception $e) {
        // Check if the error is due to a duplicate entry (email)

            return redirect()->route('dashboard')->with('error', 'User exist.');
    }
}
public function edit(User $user): View
{
    return view('admin.users.edit', compact('user'));
}

public function update(Request $request, User $user): RedirectResponse
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        'role' => ['required', 'in:admin,employee,client'], // Include 'admin' to validate, but check further
        'password' => ['nullable', 'string', 'min:8', 'confirmed']
    ]);

    // Prevent changing the role of an admin to something else if they are editing their own account
    if (Auth::id() === $user->id && $user->role === 'admin' && $validated['role'] !== 'admin') {
        return back()->with('error', 'You cannot change your role.');
    }

    $updateData = [
        'name' => $validated['name'],
        'email' => $validated['email'],
        'role' => $validated['role']
    ];

    if ($request->filled('password')) {
        $updateData['password'] = Hash::make($validated['password']);
    }

    $user->update($updateData);

    return redirect()->route('dashboard')->with('success', 'User updated successfully');
}

public function destroy(User $user): RedirectResponse
{
    if ($user->id === Auth::id()) {
        return back()->with('error', 'You cannot delete your own account.');
    }

    $user->delete();
    return back()->with('success', 'User deleted successfully');
}
    public function gstModule()
{
    // Return a view for the GST module
    return view('admin.gst-module');
}


    public function viewReports(): View
{
    $userStats = [
        'total_users' => User::count(),
        'users_by_role' => [
            'admin' => User::where('role', 'admin')->count(),
            'employee' => User::where('role', 'employee')->count(),
            'client' => User::where('role', 'client')->count(),
        ],
        'recent_users' => User::latest()->take(5)->get()
    ];

    return view('admin.view-reports', compact('userStats')); // Ensure this matches your Blade file name
}
    public function settings(): View
    {
        return view('admin.settings');
    }

    public function updateSettings(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'site_name' => ['required', 'string', 'max:255'],
        'email_notifications' => ['boolean'],
        'maintenance_mode' => ['boolean'],
    ]);

    // Save settings to the database or configuration
    // For demonstration, let's assume you're storing settings in a `settings` table
    // You might need to implement logic to store these settings.

    // Example: Setting::updateOrCreate(['key' => 'site_name'], ['value' => $validated['site_name']]);

    return back()->with('success', 'Settings updated successfully.');
}

    public function profile(): View|RedirectResponse
    {
        if (!Auth::hasUser()) {
            return to_route('login');
        }

        return view('admin.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        if (!Auth::hasUser()) {
            return to_route('login');
        }

        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'current_password' => ['required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'confirmed', Password::defaults()]
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email']
        ]);

        if ($request->filled('new_password')) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully');
    }
    public function dashboard(): View
{
    $userCounts = User::select('role', \DB::raw('count(*) as total'))
                      ->groupBy('role')
                      ->pluck('total', 'role');

    return view('admin.dashboard', [
        'userCounts' => $userCounts,
        'totalUsers' => User::count(),
    ]);
}
}
