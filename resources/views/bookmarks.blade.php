<x-app-layout>
    <x-slot name="title">My Bookmarked Trips</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Bookmarked Trips') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="bg-green-100 text-white px-4 py-3 rounded-md">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="bg-red-100 text-red-800 px-4 py-3 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            @forelse ($bookmarkedTrips as $trip)
                
                <div class="mt-4 flex space-x-3">    
                    <form method="POST" action="{{ route('bookmarks.remove', $trip->id) }}"
                        onsubmit="return confirm('Are you sure you want to remove this bookmark?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                            ❌ Remove Bookmark
                        </button>
                    </form>
                </div>


                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-white">
                        {{ $trip->user->name }}'s Trip to {{ $trip->destination }}
                    </h3>

                    <p class="mt-2 text-gray-700 dark:text-gray-300"><strong>From:</strong> {{ $trip->start_location }}</p>
                    <p class="text-gray-700 dark:text-gray-300"><strong>Highlight:</strong> {{ $trip->best_thing }}</p>
                    <p class="text-gray-700 dark:text-gray-300"><strong>Rating:</strong> {{ $trip->rating }} / 5 ⭐</p>


                    <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                        Bookmarked on {{ $trip->pivot->created_at->format('M d, Y') }}
                    </p>

                    <div class="mt-4">
                        <a href="{{ route('trip.comments', $trip->id) }}"
                           class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                            View Trip
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-600 dark:text-gray-300">You haven't bookmarked any trips yet. Bookmark one now!</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
