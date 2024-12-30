<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    // Display the dashboard
    public function index()
    {
        $users = User::all();
        return view('dashboard', compact('users'));
    }

    // Add a new employee
    public function addEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'employee', // Setting the role to 'employee'
            'password' => bcrypt('password'), // Default password
        ]);

        return redirect()->back()->with('success', 'Employee added successfully!');
    }

    // Add a new client
    public function addClient(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'client', // Setting the role to 'client'
            'password' => bcrypt('password'), // Default password
        ]);

        return redirect()->back()->with('success', 'Client added successfully!');
    }
    // Edit user view
public function editUser($id)
{
    $user = User::findOrFail($id);
    return view('admin.edit-user', compact('user'));
}

// Update user details
public function updateUser(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|string',
    ]);

    $user = User::findOrFail($id);
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
    ]);

    return redirect()->back()->with('success', 'User updated successfully!');
}

// Delete user
public function deleteUser($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->back()->with('success', 'User deleted successfully!');
}

}

