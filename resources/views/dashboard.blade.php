<x-app-layout>
<x-slot name="title">Welcome To TripShare</x-slot>
<x-slot name="header">
        <div class="flex space-x-8 items-center">
            <a href="{{ route('dashboard') }}"
               class="text-lg font-semibold text-gray-700 dark:text-gray-300 hover:underline">
                Welcome to TripShare
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">
                    <h2 class="text-2xl font-bold">Welcome, {{ Auth::user()->name }}! 👋</h2>

                    <p class="text-lg">
                        You're logged into <strong>TripShare</strong>, a place where you can share your travel experiences, explore adventures from other users, and bookmark your favorite trips for future inspiration.
                    </p>

                    <p>
                        Use the navigation menu to:
                    </p>
                    <ul class="list-disc list-inside space-y-1">
                        <li><strong>View All Trips</strong> submitted by users.</li>
                        <li><strong>Add a New Trip</strong> to share your latest adventure.</li>
                        <li><strong>Comment on Trips</strong> and join the travel conversation.</li>
                        <li><strong>Bookmark Trips</strong> you love and revisit them anytime.</li>
                    </ul>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Happy exploring and sharing! 🌍✈️
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Don't Know Where To Go Next?</h3>
                
                <p class="mb-4 text-gray-700 dark:text-gray-300">
                    <strong>
                    Enter information and places you want to visit. Our third party services can aid you in planning your next trip!
                    </strong>
                </p>

                <form method="POST" action="{{ route('questions.api.generateTrips') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="api_input" class="block text-sm font-medium text-white">
                            Let us know what type of trip you want!
                        </label>
                        <input type="text" id="api_input" name="api_input" required
                            value="{{ old('api_input', session('api_input')) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 text-black"
                            placeholder="I really loved going to... becuase of...">
                    </div>

                    <div>
                        <x-primary-button>
                            {{ __('Read About Your New Trip') }}
                        </x-primary-button>
                    </div>
                </form>
                @if (session('ai_response'))
                    <div class="mt-1 block w-full rounded-md border-gray-300 text-white">
                        <strong>You Should Visit...</strong>
                        <p>{{ session('ai_response') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mt-4 p-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded shadow">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
