@extends('layouts.app')

@section('content')
<div class="bg-gray-800 min-h-screen p-6">
    <h1 class="text-3xl text-white mb-6">Edit User</h1>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full border-gray-600 bg-gray-800 text-white rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full border-gray-600 bg-gray-800 text-white rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-300">Role</label>
            <select name="role" id="role" class="mt-1 block w-full border-gray-600 bg-gray-800 text-white rounded-md" >
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }}>Employee</option>
                <option value="client" {{ $user->role == 'client' ? 'selected' : '' }}>Client</option>
            </select>
        </div>

        <div class="flex justify-end">
            <button type="button" class="bg-gray-700 text-gray-300 px-4 py-2 rounded mr-2" onclick="window.history.back()">Cancel</button>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update User</button>
        </div>
    </form>
</div>
@endsection
