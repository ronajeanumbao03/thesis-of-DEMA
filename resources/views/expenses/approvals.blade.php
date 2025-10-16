@extends('layouts.app')

@section('content')

{{-- @auth
    <div>
        You are logged in as ID: {{ auth()->user()->id }} | Role: {{ auth()->user()->role }}
    </div>
@endauth --}}

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Pending Approvals</h1>

    @if($expenses->isEmpty())
        <p class="text-gray-500 dark:text-gray-300">No pending expenses.</p>
    @else
        <div class="grid gap-4">
            @foreach($expenses as $expense)
                <div class="bg-white dark:bg-gray-800 shadow-md p-4 rounded-md">
                    <div class="text-lg font-medium">{{ $expense->user->first_name }} {{ $expense->user->last_name }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        Amount: <strong>₱{{ number_format($expense->amount, 2) }}</strong><br>
                        Description: {{ $expense->description }}<br>
                        Submitted: {{ $expense->created_at->diffForHumans() }}
                    </div>
                    <div class="mt-3 flex gap-2">
                        <form action="{{ route('expenses.approve', $expense) }}" method="POST">
                            @csrf
                            <button class="px-4 py-1 bg-green-600 text-white rounded hover:bg-green-700"><x-heroicon-s-hand-thumb-up class="w-5 h-5" /></button>
                        </form>
                        <form action="{{ route('expenses.reject', $expense) }}" method="POST">
                            @csrf
                            <button class="px-4 py-1 bg-red-600 text-white rounded hover:bg-red-700"><x-heroicon-s-hand-thumb-down class="w-5 h-5" /></button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
