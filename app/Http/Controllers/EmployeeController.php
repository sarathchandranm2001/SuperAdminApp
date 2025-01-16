<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    public function index(): View
    {
        // Basic statistics for employee dashboard
        $stats = [
            'total_tasks' => 0, // Replace with actual task count
            'pending_tasks' => 0, // Replace with actual pending task count
            'completed_tasks' => 0 // Replace with actual completed task count
        ];

        return view('employee.dashboard', compact('stats'));
    }

    public function profile(): View|RedirectResponse
    {
        if (!Auth::hasUser()) {
            return to_route('login');
        }

        return view('employee.profile', ['user' => Auth::user()]);
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
            $user->save();
        }

        return back()->with('success', 'Profile updated successfully');
    }

    public function viewReports(): View
    {
        // Get reports relevant to the employee
        $employeeStats = [
            'monthly_tasks' => 0, // Replace with actual monthly task count
            'performance_metrics' => [], // Replace with actual performance metrics
            'recent_activities' => [] // Replace with actual recent activities
        ];

        return view('employee.view-reports', compact('employeeStats'));
    }

    public function settings(): View
    {
        return view('employee.settings');
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'notification_preferences' => ['boolean'],
            'display_preferences' => ['string', 'max:255'],
            'timezone' => ['string', 'max:255'],
        ]);

        // Implementation for updating employee-specific settings
        // You might want to store these in a settings table or user preferences

        return back()->with('success', 'Settings updated successfully');
    }

    public function loadContent($target): View
    {
        Log::info('Loading content for target: ' . $target);

        try {
            // Convert hyphens to dots for view resolution
            $viewName = str_replace('-', '.', $target);

            // Check if view exists and if the employee has permission to access it
            if (!view()->exists("employee.{$viewName}")) {
                Log::error('View not found: employee.' . $viewName);
                abort(404, 'Page not found');
            }

            // You might want to add additional authorization checks here
            return view("employee.{$viewName}");

        } catch (\Exception $e) {
            Log::error('Error loading content: ' . $e->getMessage());
            abort(500, 'Error loading content');
        }
    }

    public function dashboard(): View
    {
        // Get employee-specific dashboard data
        $dashboardData = [
            'tasks_overview' => [
                'pending' => 0, // Replace with actual pending tasks
                'in_progress' => 0, // Replace with actual in-progress tasks
                'completed' => 0 // Replace with actual completed tasks
            ],
            'recent_activities' => [], // Replace with actual recent activities
            'upcoming_deadlines' => [] // Replace with actual deadlines
        ];

        return view('employee.dashboard', $dashboardData);
    }
}