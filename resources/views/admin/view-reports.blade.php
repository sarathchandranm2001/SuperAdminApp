<!-- resources/views/admin/view-reports.blade.php -->
<div class="ml-2">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('View Reports') }}
        </h2>
    </x-slot>

    <div class="bg-gray-800 p-6 rounded-lg shadow-md text-gray-100">
        <h3 class="text-xl mb-4">User Reports</h3>
        
        <div class="grid grid-cols-3 gap-4 mb-4 text-gray-800">
            <div class="p-4 bg-blue-100 rounded">
                <p class="text-lg">Total Users</p>
                <p class="text-2xl font-bold">{{ $userStats['total_users'] }}</p>
            </div>
            <div class="p-4 bg-green-100 rounded">
                <p class="text-lg">Total Admins</p>
                <p class="text-2xl font-bold">{{ $userStats['users_by_role']['admin'] }}</p>
            </div>
            <div class="p-4 bg-yellow-100 rounded">
                <p class="text-lg">Total Employees</p>
                <p class="text-2xl font-bold">{{ $userStats['users_by_role']['employee'] }}</p>
            </div>
            <div class="p-4 bg-red-100 rounded">
                <p class="text-lg">Total Clients</p>
                <p class="text-2xl font-bold">{{ $userStats['users_by_role']['client'] }}</p>
            </div>
        </div>
    
        <h4 class="text-lg mb-2">Recent Users</h4>
        <ul class="list-disc pl-5">
            @foreach($userStats['recent_users'] as $recentUser)
                <li>{{ $recentUser->name }} ({{ $recentUser->email }})</li>
            @endforeach
        </ul>
    </div>
</div>

