@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto mt-6">
        <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">
            Edit Budget for {{ $department->name }}
        </h1>

        <form action="{{ route('departments.budget.update', $department->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-200">Annual Budget</label>
                <input type="number" name="annual_budget" step="0.01" value="{{ $department->annual_budget }}"
                       class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white" required>
            </div>

            <div class="flex justify-end gap-2 pt-4">
                <a href="{{ route('departments.index') }}"
                   class="text-gray-600 dark:text-gray-300 hover:underline">Cancel</a>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Update Budget
                </button>
            </div>
        </form>
    </div>
@endsection
