@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Application Settings</h1>

        <form method="POST" action="{{ route('settings.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- App Name -->
            <div>
                <label for="app_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Application
                    Name</label>
                <input id="app_name" name="app_name" type="text" value="{{ config('app.name') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <!-- Enable Notifications -->
            <div class="flex items-center">
                <input id="enable_notifications" name="enable_notifications" type="checkbox"
                    {{ $enable_notifications ? 'checked' : '' }}
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="enable_notifications" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                    Enable Notifications
                </label>
            </div>

            <!-- Maintenance Mode -->
            {{-- <div class="flex items-center">
                <input id="maintenance_mode" name="maintenance_mode" type="checkbox"
                    {{ app()->isDownForMaintenance() ? 'checked' : '' }}
                    class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                <label for="maintenance_mode" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                    Maintenance Mode
                </label>
            </div> --}}

            <!-- Submit -->
            <div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Save
                    Settings</button>
            </div>
        </form>
    </div>
@endsection
