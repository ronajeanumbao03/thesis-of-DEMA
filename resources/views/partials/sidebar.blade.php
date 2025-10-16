<aside :class="sidebarOpen ? 'w-64' : 'w-16'"
    class="fixed top-0 left-0 h-screen z-30 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow transition-all duration-300 flex flex-col">

    <!-- Logo -->
    <div class="flex items-center justify-center h-16 border-b border-gray-300 dark:border-gray-700">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/DEMA-Logo.png') }}" :class="sidebarOpen ? 'w-10' : 'w-8'"
                class="transition-all duration-300 h-auto" alt="DEMA Logo">
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 mt-4 px-2 space-y-2 overflow-y-auto">

        @if (auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 p-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900 transition group">
                <x-heroicon-s-home class="w-6 h-6" />
                <span x-show="sidebarOpen" class="whitespace-nowrap">Dashboard</span>
            </a>
            <a href="{{ route('departments.index') }}"
                class="flex items-center gap-3 p-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900 transition group">
                <x-heroicon-s-banknotes class="w-6 h-6" />
                <span x-show="sidebarOpen" class="whitespace-nowrap">Department Budgets</span>
            </a>
            <a href="{{ route('admin.expense-reports.index') }}"
                class="flex items-center gap-3 p-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900 transition group">
                <x-heroicon-s-document-text class="w-6 h-6" />
                <span x-show="sidebarOpen" class="whitespace-nowrap">Expense Reports</span>
            </a>
            <a href="{{ route('departments.show-assign-head') }}"
                class="flex items-center gap-3 p-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900 transition group">
                <x-heroicon-s-user class="w-6 h-6" />
                <span x-show="sidebarOpen" class="whitespace-nowrap">Department Head</span>
            </a>
            <a href="{{ route('departments.show-assign-user') }}"
                class="flex items-center gap-3 p-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900 transition group">
                <x-heroicon-s-user-group class="w-6 h-6" />
                <span x-show="sidebarOpen" class="whitespace-nowrap">Department User</span>
            </a>
            <a href="{{ route('users.index') }}"
                class="flex items-center gap-3 p-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900 transition group">
                <x-heroicon-s-users class="w-6 h-6" />
                <span x-show="sidebarOpen" class="whitespace-nowrap">Manage Users</span>
            </a>
            <a href="{{ route('settings.index') }}"
                class="flex items-center gap-3 p-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900 transition group">
                <x-heroicon-s-wrench-screwdriver class="w-6 h-6" />
                <span x-show="sidebarOpen" class="whitespace-nowrap">Settings</span>
            </a>
        @endif

        @if (auth()->user()->role === 'head')
            <a href="{{ route('head.dashboard') }}"
                class="flex items-center gap-3 p-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900 transition group">
                <x-heroicon-s-home class="w-6 h-6" />
                <span x-show="sidebarOpen" class="whitespace-nowrap">Dashboard</span>
            </a>
            <a href="{{ route('budget.summary') }}"
                class="flex items-center gap-3 p-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900 transition group">
                <x-heroicon-s-building-storefront class="w-6 h-6" />
                <span x-show="sidebarOpen" class="whitespace-nowrap">My Department Budget</span>
            </a>
            <a href="{{ route('expenses.approvals') }}"
                class="flex items-center gap-3 p-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900 transition group">
                <x-heroicon-s-hand-thumb-up class="w-6 h-6" />
                <span x-show="sidebarOpen" class="whitespace-nowrap">Pending Approvals</span>
            </a>
            <a href="{{ route('expenses.history') }}"
                class="flex items-center gap-3 p-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900 transition group">
                <x-heroicon-s-receipt-percent class="w-6 h-6" />
                <span x-show="sidebarOpen" class="whitespace-nowrap">Expense History</span>
            </a>
            <a href="{{ route('reports.index') }}"
                class="flex items-center gap-3 p-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900 transition group">
                <x-heroicon-s-presentation-chart-line class="w-6 h-6" />
                <span x-show="sidebarOpen" class="whitespace-nowrap">Reports</span>
            </a>
        @endif

        @if (auth()->user()->role === 'user')
            <a href="{{ route('user.dashboard') }}"
                class="flex items-center gap-3 p-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900 transition group">
                <x-heroicon-s-home class="w-6 h-6" />
                <span x-show="sidebarOpen" class="whitespace-nowrap">Dashboard</span>
            </a>
            <a href="{{ route('expenses.create') }}"
                class="flex items-center gap-3 p-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900 transition group">
                <x-heroicon-s-receipt-percent class="w-6 h-6" />
                <span x-show="sidebarOpen" class="whitespace-nowrap">Submit Expense</span>
            </a>
            <a href="{{ route('expenses.my-submissions') }}"
                class="flex items-center gap-3 p-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900 transition group">
                <x-heroicon-s-document-check class="w-6 h-6" />
                <span x-show="sidebarOpen" class="whitespace-nowrap">My Submissions</span>
            </a>
            <a href="{{ route('budget.user-summary') }}"
                class="flex items-center gap-3 p-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900 transition group">
                <x-heroicon-s-banknotes class="w-6 h-6" />
                <span x-show="sidebarOpen" class="whitespace-nowrap">Budget Summary</span>
            </a>
        @endif
    </nav>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}" class="mt-auto mb-4 px-2">
        @csrf
        <button type="submit"
            class="flex items-center gap-3 w-full p-2 rounded text-red-600 hover:bg-red-100 dark:hover:bg-red-900 transition group">
            <x-heroicon-s-arrow-left-on-rectangle class="w-6 h-6" />
            <span x-show="sidebarOpen" class="whitespace-nowrap">Logout</span>
        </button>
    </form>
</aside>
