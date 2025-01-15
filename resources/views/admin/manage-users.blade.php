<!-- resources/views/admin/manage-users.blade.php -->
<div class="ml-2">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Users') }}
        </h2>
    </x-slot>

    <div class="bg-gray-800 p-6 rounded-lg shadow-md min-h-full">
        <h3 class="text-xl text-white mb-4">Manage Users</h3>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 p-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <button class="bg-blue-600 text-white rounded px-4 py-2 mb-4" onclick="openModal()">Create New User</button>

        <div class="overflow-x-auto ">
            <table class="min-w-max w-full border-collapse border border-gray-600">
                <thead>
                    <tr>
                        <th class="border border-gray-600 p-2 text-left text-gray-300">Name</th>
                        <th class="border border-gray-600 p-2 text-left text-gray-300">Email</th>
                        <th class="border border-gray-600 p-2 text-left text-gray-300">Role</th>
                        <th class="border border-gray-600 p-2 text-left text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-700">
                            <td class="border border-gray-600 p-2 text-gray-200">{{ $user->name }}</td>
                            <td class="border border-gray-600 p-2 text-gray-200">{{ $user->email }}</td>
                            <td class="border border-gray-600 p-2 text-gray-200">{{ $user->role }}</td>
                            <td class="border border-gray-600 p-2">
                                @if ($user->role !== 'admin')
                                    <button class="text-blue-800 bg-yellow-400 px-3 m-1 p-1 rounded-md" onclick='editUser(@json($user))'>Edit</button>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-100 bg-red-600 px-3 m-1 ml-5 p-1 rounded-md">Delete</button>
                                    </form>
                                @else
                                    <span class="text-gray-400 italic">Admin actions restricted</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->links() }} <!-- For pagination -->
    </div>

    <!-- Modal for Create/Edit User -->
    <div id="userModal" class="fixed inset-0 z-50 hidden flex justify-center items-center bg-black bg-opacity-70">
        <div class="bg-gray-900 rounded-lg p-6 w-1/3">
            <h5 class="text-xl text-white mb-4" id="userModalLabel">Create User</h5>
            <form id="userForm" action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" value="POST" id="formMethod">
                <input type="hidden" name="user_id" id="user_id">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-600 bg-gray-800 text-white rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-600 bg-gray-800 text-white rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-300">Password (Leave blank to keep current)</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-600 bg-gray-800 text-white rounded-md">
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border-gray-600 bg-gray-800 text-white rounded-md">
                </div>

                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-300">Role</label>
                    <select name="role" id="role" class="mt-1 p-2 block w-full border-gray-600 bg-gray-800 text-white rounded-md">
                        <option value="">Select a role</option>
                        <option value="employee">Employee</option>
                        <option value="client">Client</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="button" class="bg-gray-700 text-gray-300 px-4 py-2 rounded mr-2" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    </div>

<!--errorcorrected-->
