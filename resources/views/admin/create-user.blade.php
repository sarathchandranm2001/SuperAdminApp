<!-- resources/views/admin/create-user.blade.php -->
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Create User') }}
    </h2>
</x-slot>

<div class="bg-gray-800 p-6 rounded-lg shadow-md">
    <h3 class="text-xl text-white mb-4">Create New User</h3>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 p-2 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
            <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-600 bg-gray-800 text-white rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
            <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-600 bg-gray-800 text-white rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
            <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-600 bg-gray-800 text-white rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border-gray-600 bg-gray-800 text-white rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-300">Role</label>
            <select name="role" id="role" class="mt-1 block w-full border-gray-600 bg-gray-800 text-white rounded-md" required>
                <option value="admin">Admin</option>
                <option value="employee">Employee</option>
                <option value="client">Client</option>
            </select>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.manage-users') }}" class="bg-gray-700 text-gray-300 px-4 py-2 rounded mr-2">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create User</button>
        </div>
    </form>
</div>