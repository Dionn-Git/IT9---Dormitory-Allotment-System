<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <span class="text-2xl">{{ __('Dashboard') }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Top Cards -->
            <div class="flex gap-6 mb-6">

                <!-- Card 1: Balance -->
                <div class="flex-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-2xl font-semibold mb-2 text-right">
                            ₱{{ number_format($contract?->payments()->where('payment_status', 'Pending')->sum('amount') ?? 0, 2) }}
                        </h3>
                        <p class="font-bold">Outstanding Balance</p>
                        <p class="text-xs text-gray-400 mt-1">
                            @if($contract)
                                Room: {{ $contract->room->name }} — ₱{{ number_format($contract->monthly_rate, 2) }}/month
                            @else
                                No active room contract
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Card 2: Notifications -->
                <div class="flex-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-2xl font-semibold mb-2 text-right">{{ $unreadCount }}</h3>
                        <p class="font-bold">Unread Notifications</p>
                        <p class="text-xs text-gray-400 mt-1">
                            <a href="{{ route('notifications') }}" class="text-blue-500 hover:text-blue-700">View all notifications →</a>
                        </p>
                    </div>
                </div>

            </div>

            <!-- Recent Notifications Table -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Recent Notifications</h3>
                        <a href="{{ route('notifications') }}" class="text-sm text-blue-500 hover:text-blue-700">View All →</a>
                    </div>
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="pb-3 font-semibold">#</th>
                                <th class="pb-3 font-semibold">Title</th>
                                <th class="pb-3 font-semibold">Message</th>
                                <th class="pb-3 font-semibold">Type</th>
                                <th class="pb-3 font-semibold">Date</th>
                                <th class="pb-3 font-semibold">Status</th>
                                <th class="pb-3 font-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notifications as $index => $notification)
                                <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700
                                    {{ !$notification->is_read ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}"
                                    x-data="{ showDetail: false }">
                                    <td class="py-3">{{ $index + 1 }}</td>
                                    <td class="py-3 font-medium">
                                        {{ $notification->title }}
                                        @if(!$notification->is_read)
                                            <span class="ml-1 w-2 h-2 rounded-full bg-blue-500 inline-block"></span>
                                        @endif
                                    </td>
                                    <td class="py-3 max-w-xs">
                                        <p class="truncate text-gray-500" x-show="!showDetail">{{ Str::limit($notification->message, 40) }}</p>
                                        <p class="text-gray-500" x-show="showDetail">{{ $notification->message }}</p>
                                    </td>
                                    <td class="py-3">
                                        <span class="px-2 py-1 text-xs rounded-full
                                            @if($notification->type === 'payment') bg-green-100 text-green-700
                                            @elseif($notification->type === 'concern') bg-yellow-100 text-yellow-700
                                            @elseif($notification->type === 'request') bg-blue-100 text-blue-700
                                            @else bg-gray-100 text-gray-700 @endif">
                                            {{ ucfirst($notification->type) }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-gray-500">{{ $notification->created_at->format('M d, Y') }}</td>
                                    <td class="py-3">
                                        @if($notification->is_read)
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-500">Read</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">Unread</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <div class="flex items-center gap-2">
                                            <button
                                                @click="showDetail = !showDetail"
                                                class="text-xs text-blue-500 hover:text-blue-700">
                                                <span x-text="showDetail ? 'Hide' : 'View'"></span>
                                            </button>
                                            @if(!$notification->is_read)
                                                <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                                    @csrf
                                                    <button type="submit" class="text-xs text-gray-400 hover:text-gray-600">
                                                        Mark read
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-6 text-center text-gray-400">No notifications yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    @if($notifications instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="mt-4">
                            {{ $notifications->links() }}
                        </div>
                    @endif

                </div>
            </div>

            <!-- Dormitory Details -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-6">Dormitory Details</h3>
                    <div class="flex gap-6">

                        <!-- Contact Number -->
                        <div class="flex-1 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-blue-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                </svg>
                                <p class="font-semibold">Contact Number</p>
                            </div>
                            @if($dormitory)
                                <p class="text-gray-500 text-sm">{{ $dormitory->contact_number }}</p>
                            @else
                                <p class="text-gray-400 text-sm">Not available</p>
                            @endif
                        </div>

                        <!-- Location -->
                        <div class="flex-1 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                <p class="font-semibold">Location</p>
                            </div>
                            @if($dormitory)
                                <p class="text-gray-500 text-sm">{{ $dormitory->address }}</p>
                            @else
                                <p class="text-gray-400 text-sm">Not available</p>
                            @endif
                        </div>

                        <!-- Operating Times -->
                        <div class="flex-1 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-green-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <p class="font-semibold">Operating Times</p>
                            </div>
                            @if($dormitory)
                                <p class="text-gray-500 text-sm">{{ $dormitory->operating_days }}: {{ $dormitory->open_time }} - {{ $dormitory->close_time }}</p>
                            @else
                                <p class="text-gray-400 text-sm">Not available</p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>