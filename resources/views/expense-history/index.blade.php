@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Expense History - My Department</h2>

        <!-- Filters -->
        <form method="GET" class="mb-6 flex flex-wrap gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm text-gray-600 dark:text-gray-300">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or Category"
                    class="w-48 px-3 py-2 rounded border dark:bg-gray-800 dark:text-white">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm text-gray-600 dark:text-gray-300">Status</label>
                <select name="status" class="w-48 px-3 py-2 rounded border dark:bg-gray-800 dark:text-white">
                    <option value="">All</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <!-- Month -->
            <div>
                <label class="block text-sm text-gray-600 dark:text-gray-300">Month</label>
                <select name="month" class="w-48 px-3 py-2 rounded border dark:bg-gray-800 dark:text-white">
                    <option value="">All</option>
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Button -->
            <div class="self-end">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Filter
                </button>
            </div>
        </form>

        <!-- Totals -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-green-100 dark:bg-green-900 p-4 rounded shadow">
                <h3 class="text-green-800 dark:text-green-200 font-bold">Approved</h3>
                <p class="text-lg font-semibold">₱{{ number_format($totalApproved, 2) }}</p>
            </div>
            <div class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded shadow">
                <h3 class="text-yellow-800 dark:text-yellow-200 font-bold">Pending</h3>
                <p class="text-lg font-semibold">₱{{ number_format($totalPending, 2) }}</p>
            </div>
            <div class="bg-red-100 dark:bg-red-900 p-4 rounded shadow">
                <h3 class="text-red-800 dark:text-red-200 font-bold">Rejected</h3>
                <p class="text-lg font-semibold">₱{{ number_format($totalRejected, 2) }}</p>
            </div>
        </div>

        <!-- Expense Table -->
        <div class="overflow-x-auto bg-white dark:bg-gray-800 p-4 rounded shadow">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-left">Category</th>
                        <th class="px-4 py-2 text-left">Amount</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Submitted By</th>
                        <th class="px-4 py-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 dark:text-gray-300">
                    @forelse($expenses as $expense)
                        <tr class="border-b dark:border-gray-600">
                            <td class="px-4 py-2">{{ $expense->expense_date }}</td>
                            <td class="px-4 py-2">{{ $expense->category }}</td>
                            <td class="px-4 py-2">₱{{ number_format($expense->amount, 2) }}</td>
                            <td class="px-4 py-2 capitalize">{{ $expense->status }}</td>
                            <td class="px-4 py-2">{{ $expense->user->first_name }} {{ $expense->user->last_name }}</td>
                            <td class="px-4 py-2 flex items-center gap-2">
                                <a href="{{ route('expenses.see', $expense->id) }}" title="View"
                                    class="text-indigo-600 hover:text-indigo-800">
                                    <x-heroicon-s-eye class="w-5 h-5" />
                                </a>

                                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this expense?')"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete" class="text-red-600 hover:text-red-800">
                                        <x-heroicon-s-trash class="w-5 h-5" />
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-400 py-4">No expense records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $expenses->links() }}
            </div>
        </div>
    </div>
@endsection
