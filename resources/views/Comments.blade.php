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
    <x-slot name="title">{{ $trip->user->name }}'s Trip to {{ $trip->destination }}</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Trip Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Trip Information -->
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 mb-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-start">
                    <!-- Trip Details -->
                    <div class="flex-1 pr-4">
                        <h3 class="text-xl font-bold text-white">
                            {{ $trip->user->name }}'s Trip to {{ $trip->destination }}
                        </h3>

                        <p class="mt-2 text-gray-700 dark:text-gray-300"><strong>From:</strong> {{ $trip->start_location }}</p>
                        <p class="text-gray-700 dark:text-gray-300"><strong>Highlight:</strong> {{ $trip->best_thing }}</p>
                        <p class="text-gray-700 dark:text-gray-300"><strong>Rating:</strong> {{ $trip->rating }} / 5 ⭐</p>

                        <div class="mt-3 text-gray-700 dark:text-gray-300">
                            <strong>Comment:</strong>
                            <p class="mt-1">{{ $trip->comment }}</p>
                        </div>

                        <p class="mt-3 text-sm text-white-500 dark:text-gray-400">
                            Posted on {{ $trip->created_at->format('M d, Y') }}
                        </p>
                    </div>
                    @auth
                        @php
                            $alreadyBookmarked = auth()->user()->bookmarkedTrips->contains($trip->id);
                        @endphp

                        @unless ($alreadyBookmarked)
                            <form method="POST" action="{{ route('bookmarks.store', $trip->id) }}">
                                @csrf
                                <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                    🔖 Bookmark
                                </button>
                            </form>
                        @else
                            <div class="px-4 py-2 text-white rounded-md font-medium">
                                ✅ Bookmarked
                            </div>
                        @endunless
                    @endauth
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Comments</h4>

                @forelse ($trip->comments as $comment)
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3 mb-3">
                        <p class="text-gray-900 dark:text-gray-100">
                            <strong>{{ $comment->user->name }}:</strong> {{ $comment->comment }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>

                        @if (auth()->check() && auth()->id() === $comment->user_id)
                            <div class="mt-2 flex space-x-2">
                                <!-- Edit Link -->
                                <a href="{{ route('comments.showEdit', ['trip' => $trip->id, 'comment' => $comment->id]) }}"
                                   class="text-yellow-500 hover:text-yellow-600 text-sm font-medium">
                                    ✏️ Edit
                                </a>

                                <!-- Delete Form -->
                                <form action="{{ route('comments.destroy', ['trip' => $trip->id, 'comment' => $comment->id]) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-700 text-sm font-medium">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400">No comments yet. Be the first to comment!</p>
                @endforelse
            </div>

            @auth
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h4 class="text-md font-semibold text-gray-800 dark:text-gray-100 mb-2">Leave a Comment</h4>
                    <form method="POST" action="{{ route('comments.store', $trip->id) }}">
                        @csrf
                        <textarea name="comment" rows="3" required
                                  class="w-full rounded-md border-gray-300 text-black shadow-sm"
                                  placeholder="Write your comment..."></textarea>

                        <button type="submit"
                                class="mt-3 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Post Comment
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</x-app-layout>
