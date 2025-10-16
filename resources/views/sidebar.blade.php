<div class="flex h-screen">
    <!-- Sidebar -->
    <div class="w-64 bg-white dark:bg-gray-900 text-gray-800 dark:text-white shadow-md">
        <div class="p-6 text-xl font-bold border-b">
            DEMA
        </div>
        <nav class="mt-4 space-y-2 px-4">
            <a href="{{ route('dashboard') }}" class="block hover:text-indigo-600">Dashboard</a>

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('users.index') }}" class="block hover:text-indigo-600">Manage Users</a>
                <a href="#" class="block hover:text-indigo-600">Budget Reports</a>
            @elseif(auth()->user()->role === 'head')
                <a href="#" class="block hover:text-indigo-600">Approvals</a>
            @elseif(auth()->user()->role === 'user')
                <a href="#" class="block hover:text-indigo-600">Submit Expense</a>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="mt-4 text-left w-full hover:text-red-600">Logout</button>
            </form>
        </nav>
    </div>

    <!-- Main content -->
    <div class="flex-1 bg-gray-100 dark:bg-gray-800 p-6">
        {{ $slot }}
    </div>
</div>
