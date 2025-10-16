@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Create Budget for Department: {{ $department->name }}</h1>
    </div>

    <form action="{{ route('departments.budget.store', $department->id) }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="annual_budget" class="block font-medium text-gray-700 dark:text-gray-200">Annual Budget</label>
            <input type="number" name="annual_budget" step="0.01" required class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white">
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Create Budget</button>
        </div>
    </form>
@endsection
