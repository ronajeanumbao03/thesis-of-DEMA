@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white dark:bg-gray-800 rounded shadow">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Expense Details</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- User -->
            <div>
                <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Submitted By</h4>
                <p class="text-lg text-gray-800 dark:text-white">
                    {{ $expense->user->first_name }} {{ $expense->user->last_name }}
                </p>
            </div>

            <!-- Department -->
            <div>
                <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Department</h4>
                <p class="text-lg text-gray-800 dark:text-white">
                    {{ $expense->department->name }}
                </p>
            </div>

            <!-- Date -->
            <div>
                <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Date</h4>
                <p class="text-lg text-gray-800 dark:text-white">{{ $expense->expense_date }}</p>
            </div>

            <!-- Category -->
            <div>
                <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Category</h4>
                <p class="text-lg text-gray-800 dark:text-white">{{ $expense->category }}</p>
            </div>

            <!-- Amount -->
            <div>
                <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Amount</h4>
                <p class="text-lg text-indigo-600 dark:text-indigo-300">₱{{ number_format($expense->amount, 2) }}</p>
            </div>

            <!-- Status -->
            <div>
                <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Status</h4>
                <p class="text-lg capitalize text-gray-800 dark:text-white">
                    <span
                        class="inline-block px-2 py-1 rounded text-white text-sm
                    {{ $expense->status === 'approved' ? 'bg-green-600' : ($expense->status === 'rejected' ? 'bg-red-600' : 'bg-yellow-600') }}">
                        {{ $expense->status }}
                    </span>
                </p>
            </div>

            <!-- Description -->
            @if ($expense->description)
                <div class="md:col-span-2">
                    <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Description</h4>
                    <p class="text-base text-gray-700 dark:text-gray-200">
                        {{ $expense->description }}
                    </p>
                </div>
            @endif

            <!-- Receipt -->
            <!-- Receipt Thumbnail with Modal -->
            @if ($expense->receipt)
                <div x-data="{ showModal: false }" class="md:col-span-2">
                    <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Receipt</h4>

                    <!-- Thumbnail -->
                    <img src="{{ asset('receipts/' . $expense->receipt) }}" alt="Receipt"
                        class="w-32 h-32 object-cover rounded cursor-pointer border border-gray-300 dark:border-gray-600 hover:opacity-80 transition"
                        @click="showModal = true">

                    <!-- Modal -->
                    <div x-show="showModal" x-cloak
                        class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50" x-transition>
                        <div class="relative bg-white dark:bg-gray-900 p-4 rounded shadow-xl max-w-3xl w-full">
                            <button @click="showModal = false"
                                class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 hover:text-red-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                            <img src="{{ asset('receipts/' . $expense->receipt) }}" alt="Receipt Full"
                                class="w-full h-auto max-h-[80vh] object-contain rounded">
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-6 text-right">
            <a href="{{ url()->previous() }}"
                class="inline-block px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                ← Back
            </a>
        </div>
    </div>
@endsection
