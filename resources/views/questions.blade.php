@if (session('success'))
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 mt-4">
        <div class="bg-green-100 text-green-800 border border-green-400
                    dark:bg-green-900 dark:text-green-200 dark:border-green-600
                    px-4 py-3 rounded relative shadow" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    </div>
@endif

<x-app-layout>
<x-slot name="title">Read About Travelers Most Recent Trips</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Share Your Most Recent Adventure') }}
        </h2>
    </x-slot>

        <!-- Add Trip Button -->
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 mb-6">
        <a href="{{ route('questions.ask') }}"
        class="inline-block px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold text-sm rounded-md shadow-md transition">
            + Add Your Most Recent Trip
        </a>
    </div>


    <!-- Trip Display Section -->
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @forelse ($allTrips as $trip)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                <a href="{{ route('trip.comments', $trip->id) }}" class="hover:underline text-indigo-600 dark:text-indigo-400">
                                    {{ $trip->user->name }}'s trip to {{ $trip->destination }}
                                </a>
                            </h3>

                            <p class="mt-2 text-gray-700 dark:text-gray-200"><strong>From:</strong> {{ $trip->start_location }}</p>
                            <p class="text-gray-700 dark:text-gray-200"><strong>To:</strong> {{ $trip->destination }}</p>
                            <p class="text-gray-700 dark:text-gray-200"><strong>Highlight:</strong> {{ $trip->best_thing }}</p>
                            <p class="text-gray-700 dark:text-gray-200"><strong>Rating:</strong> {{ $trip->rating }} / 5 ⭐</p>

                            <div class="mt-3 text-gray-700 dark:text-gray-200">
                                <strong>Comment:</strong>
                                <p class="mt-1">{{ $trip->comment }}</p>
                            </div>

                            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                                Posted on {{ $trip->created_at->format('M d, Y') }}
                            </p>

                            @if (auth()->check() && auth()->id() === $trip->user_id)
                                <div class="mt-4 flex space-x-2">
                                    <!-- Edit Button -->
                                    <a href="{{ route('trips.edit', $trip->id) }}"
                                    class="inline-block px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
                                        ✏️ Edit
                                    </a>

                                    <!-- Delete Form -->
                                    <form action="{{ route('trips.destroy', $trip->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this trip?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-600 dark:text-gray-300">No trips have been posted yet. Be the first to share your adventure!</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
