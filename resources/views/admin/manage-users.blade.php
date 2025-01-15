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

        <div class="flex justify-between items-center mb-4">
            <button class="bg-blue-600 text-white rounded px-4 py-2" onclick="openModal()">Create New User</button>

            <div class="flex items-center">
                <label for="roleFilter" class="text-gray-300 mr-2">Filter by Role:</label>
                <select id="roleFilter" onchange="filterUsers(this.value)" class="bg-gray-700 text-white rounded px-3 py-2 border border-gray-600">
                    <option value="">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="employee">Employee</option>
                    <option value="client">Client</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-max w-full border-collapse border border-gray-600">
                <thead>
                    <tr>
                        <th class="border border-gray-600 p-2 text-left text-gray-300">Name</th>
                        <th class="border border-gray-600 p-2 text-left text-gray-300">Email</th>
                        <th class="border border-gray-600 p-2 text-left text-gray-300">Role</th>
                        <th class="border border-gray-600 p-2 text-left text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-700 user-row" data-role="{{ $user->role }}">
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
        {{ $users->links() }}
    </div>


    <!-- Keep existing modal code -->
    <!-- ... -->

    <script>
        function filterUsers(role) {
            const rows = document.querySelectorAll('.user-row');

            rows.forEach(row => {
                const userRole = row.getAttribute('data-role');
                if (role === '' || userRole === role) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Keep existing JavaScript functions (openModal, closeModal, editUser)
        // ...
    </script>
</div>
