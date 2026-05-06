<x-employee-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <span class="text-2xl">{{ __('Resident History') }}</span>
        </h2>
    </x-slot>

    <div x-data="historyPage()">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- Top Bar -->
                <div class="flex items-center justify-between mb-6 gap-4">
                    <input
                        type="text"
                        x-model="search"
                        placeholder="Search by name or room..."
                        class="w-1/2 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <!-- Filter by end reason -->
                    <select
                        x-model="filterReason"
                        class="border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Reasons</option>
                        <option value="contract_ended">Contract Ended</option>
                        <option value="early_termination">Early Termination</option>
                        <option value="non_payment">Non Payment</option>
                        <option value="violation">Violation</option>
                        <option value="voluntary_exit">Voluntary Exit</option>
                    </select>
                </div>

                <!-- History Table -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Past Residents</h3>
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="pb-3 font-semibold">#</th>
                                    <th class="pb-3 font-semibold">Name</th>
                                    <th class="pb-3 font-semibold">Room</th>
                                    <th class="pb-3 font-semibold">Contract Start</th>
                                    <th class="pb-3 font-semibold">Contract End</th>
                                    <th class="pb-3 font-semibold">Monthly Rate</th>
                                    <th class="pb-3 font-semibold">End Reason</th>
                                    <th class="pb-3 font-semibold">Moved Out</th>
                                    <th class="pb-3 font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(history, index) in filteredHistory" :key="history.id">
                                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-3" x-text="index + 1"></td>
                                        <td class="py-3 font-medium" x-text="history.name"></td>
                                        <td class="py-3" x-text="history.room"></td>
                                        <td class="py-3" x-text="history.contractStart"></td>
                                        <td class="py-3" x-text="history.contractEnd"></td>
                                        <td class="py-3">₱<span x-text="history.monthlyRate.toLocaleString()"></span></td>
                                        <td class="py-3">
                                            <span
                                                class="px-2 py-1 text-xs rounded-full font-semibold"
                                                :class="{
                                                    'bg-gray-100 text-gray-700': history.endReason === 'contract_ended',
                                                    'bg-yellow-100 text-yellow-700': history.endReason === 'early_termination',
                                                    'bg-red-100 text-red-700': history.endReason === 'non_payment',
                                                    'bg-orange-100 text-orange-700': history.endReason === 'violation',
                                                    'bg-blue-100 text-blue-700': history.endReason === 'voluntary_exit'
                                                }"
                                                x-text="history.endReason.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())">
                                            </span>
                                        </td>
                                        <td class="py-3" x-text="history.movedOut"></td>
                                        <td class="py-3">
                                            <button
                                                @click="openUserModal(history)"
                                                class="p-1.5 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg"
                                                title="View User Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                                <tr x-show="filteredHistory.length === 0">
                                    <td colspan="9" class="py-6 text-center text-gray-400">No history found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <!-- USER DETAILS MODAL -->
        <div
            x-show="showUserModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-[500px]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Resident Details</h3>
                    <button @click="showUserModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- User Avatar -->
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 rounded-full bg-blue-500 flex items-center justify-center text-white text-2xl font-bold"
                        x-text="selectedHistory.name ? selectedHistory.name.charAt(0).toUpperCase() : ''">
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100" x-text="selectedHistory.name"></h4>
                        <p class="text-sm text-gray-500" x-text="selectedHistory.email"></p>
                    </div>
                </div>

                <!-- User Details -->
                <div class="space-y-3">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 flex justify-between">
                        <p class="text-sm text-gray-500">Phone</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="selectedHistory.phone"></p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 flex justify-between">
                        <p class="text-sm text-gray-500">Gender</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="selectedHistory.gender"></p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 flex justify-between">
                        <p class="text-sm text-gray-500">Room</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="selectedHistory.room"></p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 flex justify-between">
                        <p class="text-sm text-gray-500">Contract Start</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="selectedHistory.contractStart"></p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 flex justify-between">
                        <p class="text-sm text-gray-500">Contract End</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="selectedHistory.contractEnd"></p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 flex justify-between">
                        <p class="text-sm text-gray-500">Monthly Rate</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">₱<span x-text="selectedHistory.monthlyRate"></span></p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 flex justify-between">
                        <p class="text-sm text-gray-500">End Reason</p>
                        <span
                            class="text-xs px-2 py-1 rounded-full font-semibold"
                            :class="{
                                'bg-gray-100 text-gray-700': selectedHistory.endReason === 'contract_ended',
                                'bg-yellow-100 text-yellow-700': selectedHistory.endReason === 'early_termination',
                                'bg-red-100 text-red-700': selectedHistory.endReason === 'non_payment',
                                'bg-orange-100 text-orange-700': selectedHistory.endReason === 'violation',
                                'bg-blue-100 text-blue-700': selectedHistory.endReason === 'voluntary_exit'
                            }"
                            x-text="selectedHistory.endReason ? selectedHistory.endReason.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) : ''">
                        </span>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 flex justify-between">
                        <p class="text-sm text-gray-500">Remarks</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="selectedHistory.remarks || 'None'"></p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 flex justify-between">
                        <p class="text-sm text-gray-500">Moved Out</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="selectedHistory.movedOut"></p>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button @click="showUserModal = false" class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg">Close</button>
                </div>
            </div>
        </div>

    </div>

</x-employee-layout>

<script>
function historyPage() {
    return {
        search: '',
        filterReason: '',
        showUserModal: false,
        selectedHistory: {},

        history: [
            {
                id: 1,
                name: 'Juan Dela Cruz',
                email: 'juan@email.com',
                phone: '09123456789',
                gender: 'Male',
                room: 'Room 101',
                contractStart: '2025-01-01',
                contractEnd: '2025-12-31',
                monthlyRate: 3000,
                endReason: 'contract_ended',
                remarks: 'Good tenant',
                movedOut: '2025-12-31',
            },
            {
                id: 2,
                name: 'Maria Santos',
                email: 'maria@email.com',
                phone: '09234567890',
                gender: 'Female',
                room: 'Room 202',
                contractStart: '2025-03-01',
                contractEnd: '2025-09-01',
                monthlyRate: 5000,
                endReason: 'early_termination',
                remarks: 'Left due to personal reasons',
                movedOut: '2025-09-01',
            },
            {
                id: 3,
                name: 'Pedro Reyes',
                email: 'pedro@email.com',
                phone: '09345678901',
                gender: 'Male',
                room: 'Room 103',
                contractStart: '2025-06-01',
                contractEnd: '2025-12-01',
                monthlyRate: 3000,
                endReason: 'non_payment',
                remarks: 'Missed 3 months of payment',
                movedOut: '2025-12-01',
            },
        ],

        get filteredHistory() {
            return this.history.filter(h => {
                const matchSearch = !this.search ||
                    h.name.toLowerCase().includes(this.search.toLowerCase()) ||
                    h.room.toLowerCase().includes(this.search.toLowerCase());
                const matchReason = !this.filterReason || h.endReason === this.filterReason;
                return matchSearch && matchReason;
            });
        },

        openUserModal(history) {
            this.selectedHistory = { ...history };
            this.showUserModal = true;
        },
    }
}
</script>