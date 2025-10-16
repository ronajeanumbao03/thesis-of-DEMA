@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Create New User</h1>
    </div>
    @if ($errors->any())
        <div class="mb-4 text-red-500">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('users.store') }}" class="space-y-4 max-w-xl">
        @csrf

        <div>
            <label class="block font-medium">First Name</label>
            <input name="first_name" value="{{ old('first_name') }}" required
                class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block font-medium">Middle Name</label>
            <input name="middle_name" value="{{ old('middle_name') }}"
                class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block font-medium">Last Name</label>
            <input name="last_name" value="{{ old('last_name') }}" required
                class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block font-medium">Username</label>
            <input name="username" value="{{ old('username') }}" required
                class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block font-medium">Address</label>
            <input name="address" value="{{ old('address') }}"
                class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block font-medium">Gender</label>
            <select name="gender" class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white">
                <option value="">-- Select Gender --</option>
                <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <div>
            <label class="block font-medium">Birthdate</label>
            <input type="date" name="birthdate" value="{{ old('birthdate') }}"
                class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block font-medium">Role</label>
            <select name="role" required class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white">
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="head" {{ old('role') === 'head' ? 'selected' : '' }}>Head</option>
                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>

        <div>
            <label class="block font-medium">Status</label>
            <select name="status" required class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white">
                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div>
            <label class="block font-medium">Password</label>
            <input type="password" name="password" required
                class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block font-medium">Confirm Password</label>
            <input type="password" name="password_confirmation" required
                class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white">
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Create User
            </button>
            <a href="{{ route('users.index') }}"
                class="ml-3 text-sm text-gray-600 dark:text-gray-300 hover:underline">Cancel</a>
        </div>
    </form>
@endsection
