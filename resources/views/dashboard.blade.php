<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        {{-- Admin Section --}}
        @if (Auth::user()->role == 'admin')
            <div class="bg-gray-100 p-4 rounded-md shadow-md">
                <h2 class="font-bold text-xl text-gray-800">Admin Section</h2>
                
                <!-- Toggle for Add Employee Form -->
                <button onclick="toggleSection('addEmployee')" class="w-full bg-blue-500 text-black p-2 rounded-md">
                    Add Employee
                </button>
                <div id="addEmployee" class="space-y-4 mt-4 hidden">
                    <form method="POST" action="{{ url('/admin/add-employee') }}">
                        @csrf
                        <input type="text" name="name" placeholder="Employee Name" required class="w-full p-2 border border-gray-300 rounded-md">
                        <input type="email" name="email" placeholder="Employee Email" required class="w-full p-2 border border-gray-300 rounded-md">
                        <button type="submit" class="w-full bg-blue-500 text-black p-2 rounded-md">Add Employee</button>
                    </form>
                </div>

                <!-- Toggle for Add Client Form -->
                <button onclick="toggleSection('addClient')" class="w-full bg-blue-500 text-black p-2 rounded-md mt-4">
                    Add Client
                </button>
                <div id="addClient" class="space-y-4 mt-4 hidden">
                    <form method="POST" action="{{ url('/admin/add-client') }}">
                        @csrf
                        <input type="text" name="name" placeholder="Client Name" required class="w-full p-2 border border-gray-300 rounded-md">
                        <input type="email" name="email" placeholder="Client Email" required class="w-full p-2 border border-gray-300 rounded-md">
                        <button type="submit" class="w-full bg-blue-500 text-black p-2 rounded-md">Add Client</button>
                    </form>
                </div>

                <!-- Toggle for All Users Table -->
                <button onclick="toggleSection('allUsers')" class="w-full bg-blue-500 text-black p-2 rounded-md mt-4">
                    View All Users
                </button>
                <div id="allUsers" class="mt-4 hidden">
                    <h2 class="font-bold text-xl text-gray-800">All Users</h2>
                    <table class="min-w-full table-auto mt-4">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Role</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $user->name }}</td>
                                    <td class="px-4 py-2">{{ $user->email }}</td>
                                    <td class="px-4 py-2">{{ $user->role }}</td>
                                    <td class="px-4 py-2 flex space-x-2">
                                        <a href="{{ url('/admin/edit-user', $user->id) }}" class="bg-yellow-500 text-black px-2 py-1 rounded-md">Edit</a>
                                        <form method="POST" action="{{ url('/admin/delete-user', $user->id) }}" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-black px-2 py-1 rounded-md">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- Employee Section --}}
        @if (Auth::user()->role == 'employee')
            <div class="bg-gray-100 p-4 rounded-md shadow-md">
                <h2 class="font-bold text-xl text-gray-800">Employee Section</h2>
                <!-- Employee-specific content -->
            </div>
        @endif

        {{-- Client Section --}}
        @if (Auth::user()->role == 'client')
            <div class="bg-gray-100 p-4 rounded-md shadow-md">
                <h2 class="font-bold text-xl text-gray-800">Client Section</h2>
                <!-- Client-specific content -->
            </div>
        @endif
    </div>

    <script>
        function toggleSection(sectionId) {
            const section = document.getElementById(sectionId);
            if (section.classList.contains('hidden')) {
                section.classList.remove('hidden');
            } else {
                section.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>
