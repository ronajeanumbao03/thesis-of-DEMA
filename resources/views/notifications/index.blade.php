@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">My Notifications</h1>

        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded dark:bg-green-800 dark:text-green-100">
                {{ session('success') }}
            </div>
        @endif

        @if ($notifications->count() > 0)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($notifications as $notification)
                    <div class="px-6 py-4 flex justify-between items-center">
                        <div class="flex-1">
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                {{ $notification->message }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>

                        @if (!$notification->read)
                            <form method="POST" action="{{ route('notifications.mark-read', $notification->id) }}">
                                @csrf
                                <button class="text-sm text-indigo-600 hover:underline dark:text-indigo-400">
                                    Mark as Read
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="text-gray-600 dark:text-gray-400 text-center py-12">
                You have no notifications.
            </div>
        @endif
    </div>
@endsection
