@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">User Management</h1>
        <p class="text-gray-600 dark:text-gray-400">List of all registered users.</p>
    </div>

    <!-- Controls: Per Page Dropdown & Search -->
    <div class="flex justify-between items-center mb-4">
        <!-- Show Entries Dropdown -->
        <form method="GET" action="{{ route('users.index') }}" class="flex items-center gap-2">
            <span class="text-sm text-gray-600 dark:text-gray-300">Show</span>
            <select name="per_page" onchange="this.form.submit()"
                class="px-3 py-1 pr-6 border border-gray-300 dark:border-gray-700 rounded dark:bg-gray-700 dark:text-white text-sm appearance-none relative bg-[url('data:image/svg+xml;utf8,<svg fill=\'%23000\' height=\'24\' viewBox=\'0 0 24 24\' width=\'24\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M7 10l5 5 5-5z\'/></svg>')] bg-no-repeat bg-[right_0.5rem_center] bg-[length:1rem_auto]">
                @foreach ([5, 10, 25, 50, 100] as $size)
                    <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                        {{ $size }}
                    </option>
                @endforeach
            </select>
            <span class="text-sm text-gray-600 dark:text-gray-300">entries</span>

            <!-- Keep search value in pagination -->
            <input type="hidden" name="search" value="{{ request('search') }}">
        </form>

        <!-- Search + Create Button -->
        <div class="flex items-center gap-3">
            <!-- Auto Search -->
            <form method="GET" action="{{ route('users.index') }}">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                    oninput="this.form.submit()"
                    class="px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md text-sm dark:bg-gray-700 dark:text-white">
                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
            </form>

            <!-- Create User Icon -->
            <a href="{{ route('users.create') }}"
                class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md shadow transition"
                title="Create User">
                <x-heroicon-o-user-plus class="w-5 h-5" />
                <span>Create</span>
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800 rounded shadow">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700 text-left">
                    {{-- <th class="px-4 py-2">ID</th> --}}
                    <th class="px-4 py-2">Employee ID</th>
                    <th class="px-4 py-2">Full Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Role</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        {{-- <td class="px-4 py-2">{{ $user->id }}</td> --}}
                        <td class="px-4 py-2">{{ $user->employee_id }}</td>
                        <td class="px-4 py-2">{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}
                        </td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2 capitalize">{{ $user->role }}</td>
                        <td class="px-4 py-2 capitalize">{{ $user->status }}</td>
                        <td class="px-4 py-2 flex items-center gap-2">
                            <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500 hover:text-blue-700"
                                title="Edit">
                                <x-heroicon-o-pencil-square class="w-5 h-5" />
                            </a>
                            <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="inline-block"
                                onsubmit="return confirm('Are you sure you want to delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete" class="text-red-500 hover:text-red-700">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center px-4 py-4 text-gray-500 dark:text-gray-400">
                            No users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->appends(request()->query())->links('pagination::tailwind') }}
    </div>
@endsection
