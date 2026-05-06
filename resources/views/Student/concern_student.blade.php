<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <span class="text-2xl">{{ __('Concerns') }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex gap-6">

                <!-- Left Side: Submit Concern -->
                <div class="w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg h-[600px]">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Submit a Concern</h3>

                        <!-- Concern Type -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Type of Concern
                            </label>
                            <div class="flex flex-col gap-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="concern_type" value="room_damage" class="text-blue-500">
                                    <span class="text-sm">Room Damage</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="concern_type" value="people" class="text-blue-500">
                                    <span class="text-sm">People</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="concern_type" value="other" class="text-blue-500">
                                    <span class="text-sm">Other Concern</span>
                                </label>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Describe your concern
                            </label>
                            <textarea 
                                rows="5"
                                placeholder="Write your concern here..."
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-gray-100 dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 h-[280px]">
                            </textarea>
                        </div>

                        <!-- Submit Button -->
                        <button class="w-full bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-2 px-4 rounded-lg transition duration-150">
                            Submit Concern
                        </button>

                    </div>
                </div>

                <!-- Right Side: Previous Concerns -->
                <div class="flex-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg h-[600px]">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Previous Concerns</h3>

                        <div class="flex flex-col gap-4">

                            <!-- Concern 1 - Acknowledged -->
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-semibold px-2 py-1 rounded-full bg-blue-100 text-blue-700">Room Damage</span>
                                        <span class="text-xs text-gray-400">2026-04-15</span>
                                    </div>
                                    <!-- Acknowledged Badge -->
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full bg-green-100 text-green-700 flex items-center gap-1">
                                    Acknowledged
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    The ceiling fan in my room is broken and making a loud noise.
                                </p>
                                <!-- Admin Reply -->
                                <div class="mt-3 ml-4 bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                    <p class="text-xs font-semibold text-gray-500 mb-1">Admin Reply:</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">
                                        We have noted your concern. A maintenance team will visit your room on April 17.
                                    </p>
                                </div>
                            </div>

                            <!-- Concern 2 - Pending -->
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-semibold px-2 py-1 rounded-full bg-purple-100 text-purple-700">People</span>
                                        <span class="text-xs text-gray-400">2026-04-16</span>
                                    </div>
                                    <!-- Pending Badge -->
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 flex items-center gap-1">
                                    Pending
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    My roommate is being too loud at night and disturbing my sleep.
                                </p>
                            </div>

                            <!-- Concern 3 - Resolved -->
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-semibold px-2 py-1 rounded-full bg-gray-100 text-gray-700">Other</span>
                                        <span class="text-xs text-gray-400">2026-04-10</span>
                                    </div>
                                    <!-- Resolved Badge -->
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full bg-green-200 text-green-800 flex items-center gap-1">
                                    Resolved
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    The wifi in my room is very slow and keeps disconnecting.
                                </p>
                                <!-- Admin Reply -->
                                <div class="mt-3 ml-4 bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                    <p class="text-xs font-semibold text-gray-500 mb-1">Admin Reply:</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">
                                        The wifi router has been replaced. Please let us know if the issue persists.
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>