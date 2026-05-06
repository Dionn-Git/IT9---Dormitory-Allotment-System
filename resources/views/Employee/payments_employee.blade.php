<x-employee-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <span class="text-2xl">{{ __('Payments') }}</span>
        </h2>
    </x-slot>

    <div x-data="paymentsPage()">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- Top Bar -->
                <div class="flex items-center justify-between mb-6 gap-4">
                    <input
                        type="text"
                        x-model="search"
                        placeholder="Search by name or reference number..."
                        class="w-1/2 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <!-- Filter by Status -->
                    <select
                        x-model="filterStatus"
                        class="border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="Paid">Paid</option>
                        <option value="Pending">Pending</option>
                        <option value="Overdue">Overdue</option>
                    </select>

                    <!-- Filter by Month -->
                    <select
                        x-model="filterMonth"
                        class="border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Months</option>
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
                    </select>
                </div>

                <!-- Payments Table -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Payment History</h3>
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="pb-3 font-semibold">#</th>
                                    <th class="pb-3 font-semibold">Resident Name</th>
                                    <th class="pb-3 font-semibold">Room</th>
                                    <th class="pb-3 font-semibold">Month Paid</th>
                                    <th class="pb-3 font-semibold">Amount</th>
                                    <th class="pb-3 font-semibold">Method</th>
                                    <th class="pb-3 font-semibold">Reference No.</th>
                                    <th class="pb-3 font-semibold">Date Paid</th>
                                    <th class="pb-3 font-semibold">Status</th>
                                    <th class="pb-3 font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(payment, index) in filteredPayments" :key="payment.id">
                                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-3" x-text="index + 1"></td>
                                        <td class="py-3 font-medium" x-text="payment.name"></td>
                                        <td class="py-3" x-text="payment.room"></td>
                                        <td class="py-3" x-text="payment.monthPaid"></td>
                                        <td class="py-3">₱<span x-text="payment.amount.toLocaleString()"></span></td>
                                        <td class="py-3" x-text="payment.method"></td>
                                        <td class="py-3">
                                            <span class="font-mono text-xs bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded" x-text="payment.referenceNo"></span>
                                        </td>
                                        <td class="py-3" x-text="payment.datePaid"></td>
                                        <td class="py-3">
                                            <span
                                                class="px-2 py-1 text-xs rounded-full font-semibold"
                                                :class="{
                                                    'bg-green-100 text-green-700': payment.status === 'Paid',
                                                    'bg-yellow-100 text-yellow-700': payment.status === 'Pending',
                                                    'bg-red-100 text-red-700': payment.status === 'Overdue'
                                                }"
                                                x-text="payment.status">
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <div class="flex items-center gap-2">
                                                <!-- View Reference -->
                                                <button
                                                    @click="openReferenceModal(payment)"
                                                    class="p-1.5 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg"
                                                    title="View Reference Number">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                                    </svg>
                                                </button>
                                                <!-- View Screenshot -->
                                                <button
                                                    @click="openScreenshotModal(payment)"
                                                    class="p-1.5 bg-purple-100 hover:bg-purple-200 text-purple-600 rounded-lg"
                                                    title="View Screenshot">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                                    </svg>
                                                </button>
                                                <!-- Approve Button (for Pending) -->
                                                <button
                                                    x-show="payment.status === 'Pending'"
                                                    @click="approvePayment(payment)"
                                                    class="p-1.5 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg"
                                                    title="Approve Payment">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                                <tr x-show="filteredPayments.length === 0">
                                    <td colspan="10" class="py-6 text-center text-gray-400">No payments found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <!-- REFERENCE NUMBER MODAL -->
        <div
            x-show="showReferenceModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-[400px]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Reference Number</h3>
                    <button @click="showReferenceModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="space-y-3">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <p class="text-xs text-gray-500 mb-1">Resident Name</p>
                        <p class="font-semibold" x-text="selectedPayment.name"></p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <p class="text-xs text-gray-500 mb-1">Month Paid</p>
                        <p class="font-semibold" x-text="selectedPayment.monthPaid"></p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <p class="text-xs text-gray-500 mb-1">Amount</p>
                        <p class="font-semibold">₱<span x-text="selectedPayment.amount"></span></p>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                        <p class="text-xs text-blue-500 mb-1">Reference Number</p>
                        <p class="font-mono font-bold text-lg text-blue-700 dark:text-blue-300" x-text="selectedPayment.referenceNo"></p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <p class="text-xs text-gray-500 mb-1">Payment Method</p>
                        <p class="font-semibold" x-text="selectedPayment.method"></p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <p class="text-xs text-gray-500 mb-1">Date Paid</p>
                        <p class="font-semibold" x-text="selectedPayment.datePaid"></p>
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button @click="showReferenceModal = false" class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg">Close</button>
                </div>
            </div>
        </div>

        <!-- SCREENSHOT MODAL -->
        <div
            x-show="showScreenshotModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-[500px]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Payment Screenshot</h3>
                    <button @click="showScreenshotModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mb-3">
                    <p class="text-sm text-gray-500">Resident: <span class="font-semibold text-gray-900 dark:text-gray-100" x-text="selectedPayment.name"></span></p>
                    <p class="text-sm text-gray-500">Month: <span class="font-semibold text-gray-900 dark:text-gray-100" x-text="selectedPayment.monthPaid"></span></p>
                </div>
                <!-- Screenshot Display -->
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                    <template x-if="selectedPayment.screenshot">
                        <img :src="selectedPayment.screenshot" alt="Payment Screenshot" class="w-full object-contain max-h-96">
                    </template>
                    <template x-if="!selectedPayment.screenshot">
                        <div class="flex flex-col items-center justify-center h-48 bg-gray-50 dark:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 text-gray-300 mb-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                            <p class="text-sm text-gray-400">No screenshot uploaded</p>
                        </div>
                    </template>
                </div>
                <div class="flex justify-end mt-4">
                    <button @click="showScreenshotModal = false" class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg">Close</button>
                </div>
            </div>
        </div>

    </div>

</x-employee-layout>

<script>
function paymentsPage() {
    return {
        search: '',
        filterStatus: '',
        filterMonth: '',
        showReferenceModal: false,
        showScreenshotModal: false,
        selectedPayment: {},

        payments: [
            {
                id: 1,
                name: 'Juan Dela Cruz',
                room: 'Room 101',
                monthPaid: 'April',
                amount: 3000,
                method: 'GCash',
                referenceNo: 'GC-2026-001234',
                datePaid: '2026-04-01',
                status: 'Paid',
                screenshot: ''
            },
            {
                id: 2,
                name: 'Maria Santos',
                room: 'Room 202',
                monthPaid: 'April',
                amount: 5000,
                method: 'Bank Transfer',
                referenceNo: 'BT-2026-005678',
                datePaid: '2026-04-03',
                status: 'Paid',
                screenshot: ''
            },
            {
                id: 3,
                name: 'Pedro Reyes',
                room: 'Room 103',
                monthPaid: 'April',
                amount: 3000,
                method: 'GCash',
                referenceNo: 'GC-2026-009012',
                datePaid: '',
                status: 'Pending',
                screenshot: ''
            },
            {
                id: 4,
                name: 'Ana Garcia',
                room: 'Room 301',
                monthPaid: 'March',
                amount: 5000,
                method: 'Cash',
                referenceNo: 'CASH-2026-003456',
                datePaid: '',
                status: 'Overdue',
                screenshot: ''
            },
        ],

        get filteredPayments() {
            return this.payments.filter(p => {
                const matchSearch = !this.search ||
                    p.name.toLowerCase().includes(this.search.toLowerCase()) ||
                    p.referenceNo.toLowerCase().includes(this.search.toLowerCase());
                const matchStatus = !this.filterStatus || p.status === this.filterStatus;
                const matchMonth = !this.filterMonth || p.monthPaid === this.filterMonth;
                return matchSearch && matchStatus && matchMonth;
            });
        },

        openReferenceModal(payment) {
            this.selectedPayment = { ...payment };
            this.showReferenceModal = true;
        },

        openScreenshotModal(payment) {
            this.selectedPayment = { ...payment };
            this.showScreenshotModal = true;
        },

        approvePayment(payment) {
            const index = this.payments.findIndex(p => p.id === payment.id);
            if (index !== -1) {
                this.payments[index].status = 'Paid';
                this.payments[index].datePaid = new Date().toISOString().split('T')[0];
            }
        },
    }
}
</script>