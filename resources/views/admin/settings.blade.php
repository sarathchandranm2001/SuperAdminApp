<!-- resources/views/admin/settings.blade.php -->
<div class="ml-2">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Settings') }}
        </h2>
    </x-slot>

    <div class="bg-gray-800 p-6 rounded-lg shadow-md text-gray-100">
        <h3 class="text-xl mb-4">Admin Settings</h3>
    
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 p-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
    
        <form action="{{ route('admin.update.settings') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="site_name" class="block text-sm font-medium text-gray-700">Site Name</label>
                <input type="text" name="site_name" id="site_name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500" required>
            </div>
    
            <div class="mb-4">
                <label for="email_notifications" class="inline-flex items-center">
                    <input type="checkbox" name="email_notifications" id="email_notifications" class="form-checkbox">
                    <span class="ml-2">Enable Email Notifications</span>
                </label>
            </div>
    
            <div class="mb-4">
                <label for="maintenance_mode" class="inline-flex items-center">
                    <input type="checkbox" name="maintenance_mode" id="maintenance_mode" class="form-checkbox">
                    <span class="ml-2">Enable Maintenance Mode</span>
                </label>
            </div>
    
            <button type="submit" class="mt-4 bg-blue-600 text-white font-semibold py-2 px-4 rounded">Save Settings</button>
        </form>
    </div>
</div>
