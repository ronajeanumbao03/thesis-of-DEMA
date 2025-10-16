@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">My Submissions</h1>
        <p class="text-gray-600 dark:text-gray-400">List of all your submitted expenses.</p>
    </div>

    <!-- Controls: Per Page Dropdown & Search -->
    <div class="flex justify-between items-center mb-4">
        <!-- Show Entries Dropdown -->
        <form method="GET" action="{{ route('expenses.my-submissions') }}" class="flex items-center gap-2">
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

        <!-- Search Form -->
        <form method="GET" action="{{ route('expenses.my-submissions') }}">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by category..."
                oninput="this.form.submit()"
                class="px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md text-sm dark:bg-gray-700 dark:text-white">
            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800 rounded shadow">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700 text-left">
                    <th class="px-4 py-2">Expense Date</th>
                    <th class="px-4 py-2">Category</th>
                    <th class="px-4 py-2">Amount</th>
                    <th class="px-4 py-2">Status</th>
                    {{-- <th class="px-4 py-2">Actions</th> --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($expenses as $expense)
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="px-4 py-2">{{ $expense->expense_date }}</td>
                        <td class="px-4 py-2">{{ $expense->category }}</td>
                        <td class="px-4 py-2">₱{{ number_format($expense->amount, 2) }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $expense->status === 'approved' ? 'bg-green-500' : ($expense->status === 'rejected' ? 'bg-red-500' : 'bg-yellow-500') }}">
                                {{ ucfirst($expense->status) }}
                            </span>
                        </td>
                        {{-- <td class="px-4 py-2 flex items-center gap-2">
                            <a href="{{ route('expenses.show', $expense->id) }}" class="text-blue-500 hover:text-blue-700">
                                View Details
                            </a>
                        </td> --}}
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center px-4 py-4 text-gray-500 dark:text-gray-400">
                            No submissions found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $expenses->appends(request()->query())->links('pagination::tailwind') }}
    </div>
@endsection
