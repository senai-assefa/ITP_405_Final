<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Your Comment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

                <!-- Show Trip Info for Context -->
                <div class="mb-6 border-b pb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                        Trip to {{ $trip->destination }} by {{ $trip->user->name }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        From: {{ $trip->start_location }} | Rating: {{ $trip->rating }}/5
                    </p>
                </div>

                <!-- Edit Comment Form -->
                <form method="POST" action="{{ route('comments.update', ['trip' => $trip -> id ,'comment' => $comment->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="comment" class="block text-sm font-medium text-white">
                            Update Your Comment
                        </label>
                        <textarea name="comment" id="comment" rows="5" required
                                  class="mt-1 block w-full rounded-md border-gray-300 text-black shadow-sm">
                            {{ old('comment', $comment->comment) }}
                        </textarea>
                    </div>

                    <div class="flex items-center space-x-3">
                        <x-primary-button>
                            {{ __('Save Changes') }}
                        </x-primary-button>

                        <a href="{{ route('trip.comments', $trip->id) }}"
                           class="text-sm text-gray-500 dark:text-gray-300 hover:underline">
                            Cancel and return
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
