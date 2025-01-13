<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install Application</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-gray-900 text-gray-200 flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-gray-800 p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-center text-gray-100 mb-6">Application Installation</h1>
        <form action="/" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300">Admin Name</label>
                <input type="text" id="name" name="name" required
                    class="w-full mt-1 px-4 py-2 bg-gray-700 text-gray-200 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Admin Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full mt-1 px-4 py-2 bg-gray-700 text-gray-200 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full mt-1 px-4 py-2 bg-gray-700 text-gray-200 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full mt-1 px-4 py-2 bg-gray-700 text-gray-200 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label for="auth_code" class="block text-sm font-medium text-gray-300">Authentication Code</label>
                <input type="text" id="auth_code" name="auth_code" required
                    class="w-full mt-1 px-4 py-2 bg-gray-700 text-gray-200 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <button type="submit"
                class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md shadow hover:bg-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-800 transition duration-200">
                Install
            </button>
        </form>
        @if(session('alert'))
            <div class="mt-6 p-4 rounded-md text-center {{ session('alert.type') === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                {{ session('alert.message') }}
            </div>
        @endif
    </div>
</body>
</html>
