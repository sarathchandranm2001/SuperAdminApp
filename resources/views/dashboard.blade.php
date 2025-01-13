<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 p-2 mb-4 rounded">
        {{ session('success') }}
    </div>
    @elseif (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 p-2 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-2 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-gray-900 p-6 rounded-lg">
        <p class="text-gray-300 text-lg">
            Welcome, <strong class="text-blue-400">{{ $user->name }}</strong>
        </p>

        @if ($user->role === 'admin')
            <div class="admin-panel mt-4">
                <h2 class="text-2xl text-blue-400 mb-2">Admin Panel</h2>
                <div class="flex">
                    <!-- Sidebar Navigation -->
                    <div class="w-1/4 pr-4 bg-gray-800 rounded-lg p-4">
                        <ul class="list-none pl-0">
                            <li class="my-2">
                                <a href="#" class="admin-link text-blue-300 hover:text-blue-400" aria-label="Manage Users" data-target="manage-users">Manage Users</a>
                            </li>
                            <li class="my-2">
                                <a href="#" class="admin-link text-blue-300 hover:text-blue-400" aria-label="View Reports" data-target="view-reports">View Reports</a>
                            </li>
                            <li class="my-2">
                                <a href="#" class="admin-link text-blue-300 hover:text-blue-400" aria-label="Admin Settings" data-target="settings">Admin Settings</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Main Content Area -->
                    <div class="w-3/4" id="admin-content">
                        <div class="text-gray-300">Loading...</div>
                    </div>
                </div>
            </div>

            @elseif ($user->role === 'employee')
            <div class="employee-panel mt-4 text-gray-200">
                <h2 class="text-2xl text-teal-500 mb-2">Employee Panel</h2>
                <div class="flex">
                    <!-- Sidebar Navigation -->
                    <div class="w-1/4 pr-4 bg-gray-800 rounded-lg p-4 text-teal-300">
                        <ul class="list-none pl-0">
                            <li class="my-2">
                                <a href="#" class="text-teal-300 hover:text-teal-400" aria-label="My Tasks">My Tasks</a>
                            </li>
                            <li class="my-2">
                                <a href="#" class="text-teal-300 hover:text-teal-400" aria-label="Submit Report">Submit Report</a>
                            </li>
                            <li class="my-2">
                                <a href="#" class="text-teal-300 hover:text-teal-400" aria-label="View Schedule">View Schedule</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Main Content Area -->
                    <div class="w-3/4 ml-2" id="employee-content">
                        <div class="text-gray-300">Loading...</div>
                    </div>
                </div>
            </div>

        @elseif ($user->role === 'client')
            <div class="client-panel mt-4">
                <h2 class="text-2xl text-yellow-400 mb-2">Client Panel</h2>
                <div class="flex">
                    <!-- Sidebar Navigation -->
                    <div class="w-1/4 pr-4 bg-gray-800 rounded-lg p-4">
                        <ul class="list-none pl-0">
                            <li class="my-2">
                                <a href="#" class="text-yellow-300 hover:text-yellow-400" aria-label="View Services">View Services</a>
                            </li>
                            <li class="my-2">
                                <a href="#" class="text-yellow-300 hover:text-yellow-400" aria-label="Submit Feedback">Submit Feedback</a>
                            </li>
                            <li class="my-2">
                                <a href="#" class="text-yellow-300 hover:text-yellow-400" aria-label="Contact Support">Contact Support</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Main Content Area -->
                    <div class="w-3/4 ml-2" id="client-content">
                        <div class="text-gray-300 p-2">Loading...</div>
                    </div>
                </div>
            </div>
        @else
            <p class="text-red-400 text-lg">Role not recognized.</p>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('.admin-link');
            const contentDiv = document.getElementById('admin-content');

            // Load default content from localStorage
            const activeMenu = localStorage.getItem('activeMenu') || 'manage-users';
            loadContent(activeMenu);
            highlightActiveLink(activeMenu);

            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = this.getAttribute('data-target');
                    loadContent(target);
                    localStorage.setItem('activeMenu', target); // Save active menu
                    highlightActiveLink(target);
                });
            });

            function loadContent(target) {
                fetch(`/admin/${target}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(html => {
                        contentDiv.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error loading content:', error);
                        contentDiv.innerHTML = '<p class="text-red-400">Error loading content. Please try again later.</p>';
                    });
            }

            function highlightActiveLink(target) {
                links.forEach(link => {
                    if (link.getAttribute('data-target') === target) {
                        link.classList.add('font-bold', 'text-blue-400');
                    } else {
                        link.classList.remove('font-bold', 'text-blue-400');
                    }
                });
            }

            window.openModal = function() {
                const form = document.getElementById('userForm');
                form.action = "{{ route('admin.users.store') }}";

                // Reset to POST method for new users
                let methodInput = form.querySelector('input[name="_method"]');
                if (methodInput) {
                    methodInput.value = 'POST';
                }

                // Clear all fields
                form.reset();
                document.getElementById('user_id').value = '';
                document.getElementById('userModalLabel').innerText = 'Create User';

                // Show modal
                document.getElementById('userModal').classList.remove('hidden');
            };

            window.closeModal = function() {
                document.getElementById('userModal').classList.add('hidden');
            };

            window.clearForm = function() {
                document.getElementById('userForm').reset();
                document.getElementById('user_id').value = '';
                document.getElementById('userModalLabel').innerText = 'Create User';
                const input = document.querySelector('input[name="_method"]');
                if (input) input.remove(); // Remove method spoofing input if exists
            };

                        // Function to open modal for creating a new user
            function openCreateUserModal() {
                // Reset the form fields
                document.getElementById('userForm').reset();
                document.getElementById('user_id').value = ''; // Clear hidden user_id
                document.getElementById('userModalLabel').innerText = 'Create User'; // Set title for creation
                document.getElementById('userForm').action = "{{ route('admin.users.store') }}"; // Set action for creation
                document.getElementById('userModal').classList.remove('hidden'); // Show the modal
            }

            // Function to open modal for editing an existing user
            window.editUser = function(user) {
                const form = document.getElementById('userForm');
                form.action = `/admin/manage-users/${user.id}`;

                // Add method spoofing for PATCH request
                let methodInput = form.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    form.appendChild(methodInput);
                }
                methodInput.value = 'PATCH';

                // Set form fields
                document.getElementById('user_id').value = user.id;
                document.getElementById('name').value = user.name || '' ;
                document.getElementById('email').value = user.email || '';
                document.getElementById('role').value = user.role || '';

                // Clear password fields
                document.getElementById('password').value = '';
                document.getElementById('password_confirmation').value = '';

                // Update modal title
                document.getElementById('userModalLabel').innerText = 'Edit User';

                // Show modal
                document.getElementById('userModal').classList.remove('hidden');
            };
        });
    </script>
</x-app-layout>
