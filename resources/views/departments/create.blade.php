@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Create New Department</h1>
    </div>

    <form method="POST" action="{{ route('departments.store') }}" class="space-y-4 max-w-xl">
        @csrf

        <div>
            <label class="block font-medium">Department Name</label>
            <input name="name" value="{{ old('name') }}" required
                   class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block font-medium">Description</label>
            <textarea name="description" class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white">{{ old('description') }}</textarea>
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Create Department</button>
            <a href="{{ route('departments.index') }}"
               class="ml-3 text-sm text-gray-600 dark:text-gray-300 hover:underline">Cancel</a>
        </div>
    </form>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                confirmButtonColor: '#16a34a'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#dc2626'
            });
        @endif
    </script>
@endpush
@endsection
