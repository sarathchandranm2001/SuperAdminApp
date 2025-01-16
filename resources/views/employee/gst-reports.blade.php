<div class="bg-gray-800 p-6 rounded-lg">
    <h2 class="text-2xl text-blue-400 mb-4">GST Reports</h2>
    <div class="text-gray-300">
        <p>All GST-related transaction records will be displayed here.</p>
        <table class="w-full mt-4 text-gray-300">
            <thead>
                <tr class="bg-gray-900">
                    <th class="p-2">Date</th>
                    <th class="p-2">Transaction ID</th>
                    <th class="p-2">Subtotal</th>
                    <th class="p-2">GST</th>
                    <th class="p-2">Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Placeholder data -->
                <tr>
                    <td class="p-2">2025-01-16</td>
                    <td class="p-2">TRX12345</td>
                    <td class="p-2">$150</td>
                    <td class="p-2">$27</td>
                    <td class="p-2">$177</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Select all admin links and content div
    const links = document.querySelectorAll('.admin-link');
    const contentDiv = document.getElementById('admin-content');

    // Load default content from localStorage or set 'manage-users' as default
    const activeMenu = localStorage.getItem('activeMenu') || 'manage-users';
    loadContent(activeMenu);
    highlightActiveLink(activeMenu);

    // Add click event listeners to each admin link
    links.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const target = this.getAttribute('data-target'); // Get the 'data-target' attribute
            loadContent(target); // Load the corresponding content
            localStorage.setItem('activeMenu', target); // Save the active menu to localStorage
            highlightActiveLink(target); // Highlight the active link
        });
    });

    // Function to load content dynamically
    function loadContent(target) {
        // Make an AJAX request to fetch the content for the selected module
        fetch(`/admin/${target}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                contentDiv.innerHTML = html; // Update the content area with fetched HTML
            })
            .catch(error => {
                console.error('Error loading content:', error);
                contentDiv.innerHTML = '<p class="text-red-400">Error loading content. Please try again later.</p>';
            });
    }

    // Function to highlight the active sidebar link
    function highlightActiveLink(target) {
        links.forEach(link => {
            if (link.getAttribute('data-target') === target) {
                link.classList.add('font-bold', 'text-blue-400'); // Highlight active link
            } else {
                link.classList.remove('font-bold', 'text-blue-400'); // Remove highlight from others
            }
        });
    }

    // Modal handling for user creation/editing (if needed)
    window.openModal = function () {
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

    window.closeModal = function () {
        document.getElementById('userModal').classList.add('hidden');
    };

    window.editUser = function (user) {
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
        document.getElementById('name').value = user.name || '';
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