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
}
