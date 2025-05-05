<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Your Trip') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('trips.update', $trip->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Start Location -->
                    <div class="mb-4">
                        <label for="start_location" class="block text-sm font-medium text-white">Start Location</label>
                        <input type="text" id="start_location" name="start_location" required
                            value="{{ old('start_location', $trip->start_location) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 text-black shadow-sm">
                    </div>

                    <!-- Destination -->
                    <div class="mb-4">
                        <label for="destination" class="block text-sm font-medium text-white">Destination</label>
                        <input type="text" id="destination" name="destination" required
                            value="{{ old('destination', $trip->destination) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 text-black shadow-sm">
                    </div>

                    <!-- Best Thing About the Trip -->
                    <div class="mb-4">
                        <label for="best_thing" class="block text-sm font-medium text-white">Best Thing About the Trip</label>
                        <input type="text" id="best_thing" name="best_thing" required
                            value="{{ old('best_thing', $trip->best_thing) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 text-black shadow-sm">
                    </div>

                    <!-- Rating -->
                    <div class="mb-4">
                        <label for="rating" class="block text-sm font-medium text-white">Rating (1–5 Stars)</label>
                        <select id="rating" name="rating" required
                            class="mt-1 block w-full rounded-md border-gray-300 text-black shadow-sm">
                            <option value="">Select a rating</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ $trip->rating == $i ? 'selected' : '' }}>
                                    {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <!-- Comment -->
                    <div class="mb-6">
                        <label for="comment" class="block text-sm font-medium text-white">Comment About the Trip</label>
                        <textarea id="comment" name="comment" rows="5" required
                            class="mt-1 block w-full rounded-md border-gray-300 text-black shadow-sm">{{ old('comment', $trip->comment) }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <x-primary-button>
                            {{ __('Update Trip') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
