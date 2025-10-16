@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-white">Assign User to Department</h1>

        @if(session('success'))
            <div class="mt-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('departments.store-user') }}" method="POST">
            @csrf

            <!-- Department Selection -->
            <div class="mt-4">
                <label for="department_id" class="block text-sm font-medium text-gray-700">Select Department</label>
                <select name="department_id" id="department_id" class="mt-1 block w-full border-gray-300 rounded-md">
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- User Selection -->
            <div class="mt-4">
                <label for="user_id" class="block text-sm font-medium text-gray-700">Select User</label>
                <select name="user_id" id="user_id" class="mt-1 block w-full border-gray-300 rounded-md">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md">Assign User</button>
            </div>
        </form>
    </div>
@endsection
