@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded shadow p-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Edit User</h2>

    @if ($errors->any())
        <div class="mb-4">
            <ul class="list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="middle_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Middle Name</label>
                <input type="text" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}"
                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}"
                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                <input type="text" name="address" value="{{ old('address', $user->address) }}"
                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gender</label>
                <select name="gender"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Select gender</option>
                    <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ old('gender', $user->gender) === 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div>
                <label for="birthdate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Birthdate</label>
                <input type="date" name="birthdate" value="{{ old('birthdate', $user->birthdate) }}"
                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                <select name="role"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="head" {{ old('role', $user->role) === 'head' ? 'selected' : '' }}>Head</option>
                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                <select name="status"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('users.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Cancel
            </a>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
