@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-white">Budget Summary</h1>

        @if ($budget)
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                    <h2 class="text-xl font-medium">Total Budget</h2>
                    <p class="text-gray-600 dark:text-gray-300">${{ number_format($budget->total_amount, 2) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                    <h2 class="text-xl font-medium">Spent Amount</h2>
                    <p class="text-gray-600 dark:text-gray-300">${{ number_format($budget->spent_amount, 2) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                    <h2 class="text-xl font-medium">Remaining Amount</h2>
                    <p class="text-gray-600 dark:text-gray-300">${{ number_format($budget->remaining_amount, 2) }}</p>
                </div>
            </div>
        @else
            <div class="mt-6 p-4 bg-red-100 text-center rounded-md">
                <p class="text-lg font-medium text-red-600">No budget data available for your department.</p>
            </div>
        @endif

    </div>
@endsection
