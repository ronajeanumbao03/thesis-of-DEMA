<!-- resources/views/departments/select-department.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-white">Assign Department Head</h1>

        <form method="POST" action="{{ route('departments.store-head', $department->id) }}">
            @csrf

            <!-- Department Selection -->
            <div class="mt-4">
                <label for="department_id" class="block text-sm font-medium text-gray-700">Select Department</label>
                <select name="department_id" id="department_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Head Selection -->
            <div class="mt-4">
                <label for="user_id" class="block text-sm font-medium text-gray-700">Choose Department Head</label>
                <select name="user_id" id="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md">Assign Head</button>
            </div>
        </form>
    </div>
@endsection
