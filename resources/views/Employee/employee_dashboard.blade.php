<x-employee-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <span class="text-2xl">{{ __('Dashboard') }}</span>
        </h2>
    </x-slot>

    <!-- ONE x-data wrapping EVERYTHING -->
    <div x-data="calendar()">

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- 4 Data Cards -->
                <div class="grid grid-cols-4 gap-6 mb-6">

                    <!-- Card 1: Total Residents -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Total Residents</p>
                                    <h3 class="text-3xl font-bold mt-1">{{ $totalResidents ?? 0 }}</h3>
                                </div>
                                <div class="bg-blue-100 p-3 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-blue-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Available Rooms -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Available Rooms</p>
                                    <h3 class="text-3xl font-bold mt-1">{{ $availableRooms ?? 0 }}</h3>
                                </div>
                                <div class="bg-green-100 p-3 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-green-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Pending Concerns -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Pending Concerns</p>
                                    <h3 class="text-3xl font-bold mt-1">{{ $pendingConcerns ?? 0 }}</h3>
                                </div>
                                <div class="bg-yellow-100 p-3 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-yellow-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Pending Requests -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Pending Requests</p>
                                    <h3 class="text-3xl font-bold mt-1">{{ $pendingRequests ?? 0 }}</h3>
                                </div>
                                <div class="bg-purple-100 p-3 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-purple-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Payment Status Table -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold">Resident Payment Status</h3>
                            <a href="{{ route('employee.payments') }}" class="text-sm text-blue-500 hover:text-blue-700">View All Payments →</a>
                        </div>
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="pb-3 font-semibold">#</th>
                                    <th class="pb-3 font-semibold">Resident Name</th>
                                    <th class="pb-3 font-semibold">Room</th>
                                    <th class="pb-3 font-semibold">Month Covered</th>
                                    <th class="pb-3 font-semibold">Amount</th>
                                    <th class="pb-3 font-semibold">Due Date</th>
                                    <th class="pb-3 font-semibold">Paid At</th>
                                    <th class="pb-3 font-semibold">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPayments ?? [] as $index => $payment)
                                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-3">{{ $index + 1 }}</td>
                                        <td class="py-3 font-medium">{{ $payment->user->name }}</td>
                                        <td class="py-3">{{ $payment->contract->room->name ?? '—' }}</td>
                                        <td class="py-3">{{ $payment->month_covered }}</td>
                                        <td class="py-3">₱{{ number_format($payment->amount, 2) }}</td>
                                        <td class="py-3">{{ $payment->due_date }}</td>
                                        <td class="py-3">{{ $payment->paid_at ?? '—' }}</td>
                                        <td class="py-3">
                                            <span class="px-2 py-1 text-xs rounded-full font-semibold
                                                @if($payment->payment_status === 'Paid') bg-green-100 text-green-700
                                                @elseif($payment->payment_status === 'Pending') bg-yellow-100 text-yellow-700
                                                @else bg-red-100 text-red-700 @endif">
                                                {{ $payment->payment_status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-6 text-center text-gray-400">No payment records yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Calendar of Events -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <!-- Calendar Header -->
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold">Calendar of Events</h3>
                            <div class="flex items-center gap-4">
                                <button @click="prevMonth()" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                                    </svg>
                                </button>
                                <span class="font-semibold text-lg" x-text="monthYear"></span>
                                <button @click="nextMonth()" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Day Labels -->
                        <div class="grid grid-cols-7 mb-2">
                            <template x-for="day in ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']">
                                <div class="text-center text-sm font-semibold text-gray-500 py-2" x-text="day"></div>
                            </template>
                        </div>

                        <!-- Calendar Grid -->
                        <div class="grid grid-cols-7 gap-1">
                            <template x-for="blank in firstDayOfMonth" :key="'blank-' + blank">
                                <div class="h-24"></div>
                            </template>
                            <template x-for="day in daysInMonth" :key="day">
                                <div
                                    class="h-24 border border-gray-200 dark:border-gray-700 rounded-lg p-1 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 relative"
                                    :class="{ 'bg-blue-50 dark:bg-blue-900': isToday(day) }"
                                    @click="openModal(day)">

                                    <!-- Day Number -->
                                    <span
                                    class="text-sm font-semibold"
                                    :class="isToday(day) ? 'text-blue-500' : ''"
                                    x-text="day">
                                    </span>

                                    <!-- Payment indicator badge -->
                                    <template x-if="getDayPayments(day).length > 0">
                                    <div
                                        class="absolute top-1 right-1 cursor-pointer"
                                        @click.stop="openPaymentModal(day, $event)"
                                        :title="`${getDayPayments(day).length} payment(s) due`">
                                        <span class="flex items-center justify-center w-5 h-5 rounded-full bg-orange-400 text-white text-xs font-bold"
                                        x-text="getDayPayments(day).length">
                                        </span>
                                    </div>
                            </template>

                            <!-- Events -->
                            <div class="mt-1 space-y-1">
                                <template x-for="event in getEvents(day)" :key="event.id">
                                    <div
                                    class="text-xs px-1 py-0.5 rounded truncate"
                                    :class="getEventColor(event.type)"
                                    x-text="event.title">
                                    </div>
                                </template>

                            <!-- Payment pills -->
                            <template x-for="payment in getDayPayments(day).slice(0, 2)" :key="payment.id">
                                <div
                                    class="text-xs px-1 py-0.5 rounded truncate cursor-pointer"
                                    :class="getPaymentStatusColor(payment.status)"
                                    @click.stop="openPaymentModal(day, $event)"
                                    x-text="'₱ ' + payment.name">
                                </div>
                            </template>

                            <!-- Show more if more than 2 payments -->
                            <template x-if="getDayPayments(day).length > 2">
                                <div
                                    class="text-xs px-1 py-0.5 rounded truncate bg-gray-100 text-gray-600 cursor-pointer"
                                    @click.stop="openPaymentModal(day, $event)"
                                    x-text="'+' + (getDayPayments(day).length - 2) + ' more'">
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

                        <!-- Event Legend -->
                        <div class="flex flex-wrap gap-4 mt-4">
                            <div class="flex items-center gap-1">
                                <span class="w-3 h-3 rounded-full bg-blue-400 inline-block"></span>
                                <span class="text-xs text-gray-500">Maintenance</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="w-3 h-3 rounded-full bg-green-400 inline-block"></span>
                                <span class="text-xs text-gray-500">Cleaning</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="w-3 h-3 rounded-full bg-yellow-400 inline-block"></span>
                                <span class="text-xs text-gray-500">Inspection</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="w-3 h-3 rounded-full bg-purple-400 inline-block"></span>
                                <span class="text-xs text-gray-500">Other</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="w-3 h-3 rounded-full bg-green-400 inline-block"></span>
                                <span class="text-xs text-gray-500">Paid</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="w-3 h-3 rounded-full bg-yellow-400 inline-block"></span>
                                <span class="text-xs text-gray-500">Pending Payment</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="w-3 h-3 rounded-full bg-red-400 inline-block"></span>
                                <span class="text-xs text-gray-500">Overdue Payment</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="w-3 h-3 rounded-full bg-orange-400 inline-block"></span>
                                <span class="text-xs text-gray-500">Payment Count Badge</span>
                            </div>
                        </div>

        <!-- ADD EVENT MODAL -->
        <div
            x-show="showModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Add Event — Day <span x-text="selectedDay"></span>
                    </h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Event Title -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Event Title</label>
                    <input
                        type="text"
                        x-model="newEvent.title"
                        placeholder="Enter event title"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Event Type -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Event Type</label>
                    <select
                        x-model="newEvent.type"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="maintenance">Maintenance</option>
                        <option value="cleaning">Cleaning</option>
                        <option value="inspection">Inspection</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description (optional)</label>
                    <textarea
                        x-model="newEvent.description"
                        rows="2"
                        placeholder="Enter description..."
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </textarea>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3">
                    <button
                        @click="showModal = false"
                        class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                        Cancel
                    </button>
                    <button
                        @click="addEvent()"
                        class="px-4 py-2 text-sm bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                        Add Event
                    </button>
                </div>
            </div>
        </div>

        <!-- PAYMENT DETAILS MODAL -->
        <div
        x-show="showPaymentModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        x-cloak>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-[500px] max-h-[80vh] overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Payments Due — Day <span x-text="selectedDay"></span> <span x-text="monthYear"></span>
                    </h3>
                    <button @click="showPaymentModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-3">
                    <template x-for="payment in selectedDayPayments" :key="payment.id">
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <!-- Avatar -->
                                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-bold"
                                        x-text="payment.name.charAt(0).toUpperCase()">
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="payment.name"></p>
                                        <p class="text-xs text-gray-500" x-text="payment.room"></p>
                                    </div>
                                </div>
                                <span
                                    class="px-2 py-1 text-xs rounded-full font-semibold"
                                    :class="getPaymentStatusColor(payment.status)"
                                    x-text="payment.status">
                                </span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Amount Due</span>
                                <span class="font-semibold text-gray-900 dark:text-gray-100">₱<span x-text="Number(payment.amount).toLocaleString()"></span></span>
                            </div>
                            <div class="flex justify-between text-sm mt-1">
                                <span class="text-gray-500">Paid At</span>
                                <span class="font-semibold text-gray-900 dark:text-gray-100" x-text="payment.paid_at ?? 'Not yet paid'"></span>
                            </div>
                        </div>
                    </template>

                    <div x-show="selectedDayPayments.length === 0" class="text-center py-4 text-gray-400 text-sm">
                        No payments for this day.
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <button @click="showPaymentModal = false" class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg">Close</button>
                </div>
                </div>
            </div>

    </div><!-- END single x-data wrapper -->

</x-employee-layout>

<script>
function calendar() {
    return {
        currentDate: new Date(),
        showModal: false,
        selectedDay: null,
        showPaymentModal: false,
        selectedDayPayments: [],
        events: [],
        newEvent: { title: '', type: 'maintenance', description: '' },

        // Load payments from Laravel
        payments: @json($calendarPayments ?? []),

        get monthYear() {
            return this.currentDate.toLocaleString('default', { month: 'long', year: 'numeric' });
        },

        get daysInMonth() {
            return new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 0).getDate();
        },

        get firstDayOfMonth() {
            return new Date(this.currentDate.getFullYear(), this.currentDate.getMonth(), 1).getDay();
        },

        isToday(day) {
            const today = new Date();
            return day === today.getDate() &&
                this.currentDate.getMonth() === today.getMonth() &&
                this.currentDate.getFullYear() === today.getFullYear();
        },

        prevMonth() {
            this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() - 1, 1);
        },

        nextMonth() {
            this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 1);
        },

        openModal(day) {
            this.selectedDay = day;
            this.newEvent = { title: '', type: 'maintenance', description: '' };
            this.showModal = true;
        },

        addEvent() {
            if (this.newEvent.title.trim() === '') return;
            this.events.push({
                id: Date.now(),
                day: this.selectedDay,
                month: this.currentDate.getMonth(),
                year: this.currentDate.getFullYear(),
                title: this.newEvent.title,
                type: this.newEvent.type,
                description: this.newEvent.description,
            });
            this.showModal = false;
        },

        getEvents(day) {
            return this.events.filter(e =>
                e.day === day &&
                e.month === this.currentDate.getMonth() &&
                e.year === this.currentDate.getFullYear()
            );
        },

        // Get payments for a specific day
        getDayPayments(day) {
            return this.payments.filter(p =>
                p.day === day &&
                p.month === this.currentDate.getMonth() &&
                p.year === this.currentDate.getFullYear()
            );
        },

        // Open payment details modal
        openPaymentModal(day, event) {
            event.stopPropagation(); // prevent opening add event modal
            this.selectedDayPayments = this.getDayPayments(day);
            this.selectedDay = day;
            this.showPaymentModal = true;
        },

        getEventColor(type) {
            const colors = {
                maintenance: 'bg-blue-100 text-blue-700',
                cleaning: 'bg-green-100 text-green-700',
                inspection: 'bg-yellow-100 text-yellow-700',
                other: 'bg-purple-100 text-purple-700'
            };
            return colors[type] || 'bg-gray-100 text-gray-700';
        },

        getPaymentStatusColor(status) {
            const colors = {
                'Paid':    'bg-green-100 text-green-700',
                'Pending': 'bg-yellow-100 text-yellow-700',
                'Overdue': 'bg-red-100 text-red-700',
            };
            return colors[status] || 'bg-gray-100 text-gray-700';
        }
    }
}
</script>