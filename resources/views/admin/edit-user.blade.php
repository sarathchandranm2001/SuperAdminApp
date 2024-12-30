<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="bg-gray-100 p-4 rounded-md shadow-md">
                        <h2 class="font-bold text-xl text-gray-800">Edit User Details</h2>
                        <form method="POST" action="{{ url('/admin/edit-user', $user->id) }}" class="space-y-4">
                            @csrf
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" value="{{ $user->name }}" required
                                    class="w-full p-2 border border-gray-300 rounded-md">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ $user->email }}" required
                                    class="w-full p-2 border border-gray-300 rounded-md">
                            </div>

                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                <select name="role" id="role" required class="w-full p-2 border border-gray-300 rounded-md">
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }}>Employee</option>
                                    <option value="client" {{ $user->role == 'client' ? 'selected' : '' }}>Client</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full bg-blue-500 text-black p-2 rounded-md">Update User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
