@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">My Department Budget Summary</h2>

    @if (isset($message))
        <div class="bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-200 p-4 rounded shadow">
            {{ $message }}
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white">Department</h3>
                <p class="text-xl font-bold text-indigo-600 dark:text-indigo-300">{{ $department->name }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white">Total Budget</h3>
                <p class="text-xl font-bold text-green-600 dark:text-green-300">₱{{ number_format($totalBudget, 2) }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white">Total Spent</h3>
                <p class="text-xl font-bold text-red-600 dark:text-red-300">₱{{ number_format($totalSpent, 2) }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white">Remaining</h3>
                <p class="text-xl font-bold text-blue-600 dark:text-blue-300">₱{{ number_format($remaining, 2) }}</p>
            </div>
        </div>
    @endif
</div>
@endsection
