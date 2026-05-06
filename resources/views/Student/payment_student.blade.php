<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <span class="text-2xl">{{ __('Payment') }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex gap-6">

                <!-- Card 1: Balance -->
                <div class="flex-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-2xl font-semibold mb-2 text-right">₱0.00</h3>
                        <p class="font-bold">Balance</p>
                    </div>
                </div>

                <!-- Card 2: Pay Now Button -->
                <div class="flex-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col justify-between h-full">
                        <p class="font-bold mb-3">Make a Payment</p>
                        <button
                            onclick="document.getElementById('paymentModal').classList.remove('hidden')"
                            class="w-full mt-2 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold rounded-lg shadow transition-colors duration-200"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 21Z" />
                            </svg>
                            Pay Now
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="m-6">

        <!-- Payment History -->
        <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Payment History</h3>
                    <span class="text-xs text-gray-400 dark:text-gray-500">All transactions</span>
                </div>
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="pb-3 font-semibold">#</th>
                            <th class="pb-3 font-semibold">Reference No.</th>
                            <th class="pb-3 font-semibold">Description</th>
                            <th class="pb-3 font-semibold">Amount</th>
                            <th class="pb-3 font-semibold">Date</th>
                            <th class="pb-3 font-semibold">Method</th>
                            <th class="pb-3 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample Row 1 -->
                        <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="py-3">1</td>
                            <td class="py-3 font-mono text-xs text-gray-500 dark:text-gray-400">REF-00001</td>
                            <td class="py-3">Monthly Dormitory Fee</td>
                            <td class="py-3 font-semibold">₱3,500.00</td>
                            <td class="py-3">xx-xx-xxxx</td>
                            <td class="py-3">Cash</td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Paid</span>
                            </td>
                        </tr>
                        <!-- Sample Row 2 -->
                        <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="py-3">2</td>
                            <td class="py-3 font-mono text-xs text-gray-500 dark:text-gray-400">REF-00002</td>
                            <td class="py-3">Monthly Dormitory Fee</td>
                            <td class="py-3 font-semibold">₱3,500.00</td>
                            <td class="py-3">xx-xx-xxxx</td>
                            <td class="py-3">GCash</td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                            </td>
                        </tr>
                        <!-- Sample Row 3 -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="py-3">3</td>
                            <td class="py-3 font-mono text-xs text-gray-500 dark:text-gray-400">REF-00003</td>
                            <td class="py-3">Security Deposit</td>
                            <td class="py-3 font-semibold">₱1,000.00</td>
                            <td class="py-3">xx-xx-xxxx</td>
                            <td class="py-3">Bank Transfer</td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Failed</span>
                            </td>
                        </tr>
                        <!-- Empty state (remove when data is available) -->
                        {{-- 
                        <tr>
                            <td colspan="7" class="py-10 text-center text-gray-400 dark:text-gray-500 text-sm">
                                No payment records found.
                            </td>
                        </tr>
                        --}}
                    </tbody>
                </table>
            </div>
        </div>


    </div>

    <!-- ===== PAYMENT MODAL ===== -->
    <div id="paymentModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md p-6 relative">

            <!-- Close Button -->
            <button
                onclick="document.getElementById('paymentModal').classList.add('hidden')"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Modal Header -->
            <div class="mb-6">
                <div class="flex items-center gap-3 mb-1">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/40 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600 dark:text-blue-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 21Z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Make a Payment</h2>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 ml-11">Fill in the details below to submit your payment.</p>
            </div>

            <!-- Modal Form -->
            <div class="space-y-4">

                <!-- Payment Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Payment Type <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled selected>Select payment type</option>
                        <option value="monthly">Monthly Dormitory Fee</option>
                        <option value="deposit">Security Deposit</option>
                        <option value="utility">Utility Bill</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <!-- Amount -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Amount (₱) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">₱</span>
                        <input
                            type="number"
                            placeholder="0.00"
                            min="0"
                            step="0.01"
                            class="w-full pl-7 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                    </div>
                </div>

                <!-- Payment Method -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Payment Method <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled selected>Select method</option>
                        <option value="cash">Cash</option>
                        <option value="gcash">GCash</option>
                        <option value="bank">Bank Transfer</option>
                        <option value="maya">Maya</option>
                    </select>
                </div>

                <!-- Reference Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Reference Number
                        <span class="text-gray-400 font-normal text-xs">(optional)</span>
                    </label>
                    <input
                        type="text"
                        placeholder="e.g. GCash ref no."
                        class="w-full px-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <!-- Proof of Payment Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Proof of Payment
                        <span class="text-gray-400 font-normal text-xs">(optional)</span>
                    </label>
                    <label class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-blue-400 dark:hover:border-blue-500 transition-colors bg-gray-50 dark:bg-gray-700/50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400 mb-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                        </svg>
                        <span class="text-xs text-gray-400">Click to upload image or PDF</span>
                        <input type="file" class="hidden" accept="image/*,.pdf" />
                    </label>
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Notes
                        <span class="text-gray-400 font-normal text-xs">(optional)</span>
                    </label>
                    <textarea
                        rows="2"
                        placeholder="Any additional notes..."
                        class="w-full px-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                    ></textarea>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="flex gap-3 mt-6">
                <button
                    onclick="document.getElementById('paymentModal').classList.add('hidden')"
                    class="flex-1 px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                >
                    Cancel
                </button>
                <button
                    class="flex-1 px-4 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold shadow transition-colors duration-200"
                >
                    Submit Payment
                </button>
            </div>

        </div>
    </div>

    <!-- Close modal on backdrop click -->
    <script>
        document.getElementById('paymentModal').addEventListener('click', function (e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    </script>

</x-app-layout>