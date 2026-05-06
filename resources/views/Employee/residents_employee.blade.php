<x-employee-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <span class="text-2xl">{{ __('Residents') }}</span>
        </h2>
    </x-slot>

    <div x-data="residentsPage()">

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Top Bar: Search + Buttons -->
                <div class="flex items-center justify-between mb-6 gap-4">
                    <div class="flex-1">
                        <input
                            type="text"
                            x-model="search"
                            placeholder="Search resident by name or email..."
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <button
                        @click="showRequestsModal = true"
                        class="flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                        Requests
                        <span class="bg-white text-blue-500 text-xs font-bold px-2 py-0.5 rounded-full">
                            {{ $bookingRequests->count() + $changeRequests->count() }}
                        </span>
                    </button>
                </div>

                <!-- Residents Table -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Residents List</h3>
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="pb-3 font-semibold">#</th>
                                    <th class="pb-3 font-semibold">Name</th>
                                    <th class="pb-3 font-semibold">Email</th>
                                    <th class="pb-3 font-semibold">Phone</th>
                                    <th class="pb-3 font-semibold">Gender</th>
                                    <th class="pb-3 font-semibold">Room</th>
                                    <th class="pb-3 font-semibold">Contract Start</th>
                                    <th class="pb-3 font-semibold">Contract End</th>
                                    <th class="pb-3 font-semibold">Status</th>
                                    <th class="pb-3 font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($residents as $index => $contract)
                                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700"
                                        x-show="!search || '{{ strtolower($contract->user->name) }}'.includes(search.toLowerCase()) || '{{ strtolower($contract->user->email) }}'.includes(search.toLowerCase())">
                                        <td class="py-3">{{ $index + 1 }}</td>
                                        <td class="py-3 font-medium">{{ $contract->user->name }}</td>
                                        <td class="py-3">{{ $contract->user->email }}</td>
                                        <td class="py-3">{{ $contract->user->phone }}</td>
                                        <td class="py-3">{{ $contract->user->gender }}</td>
                                        <td class="py-3">{{ $contract->room->name }}</td>
                                        <td class="py-3">{{ $contract->contract_start }}</td>
                                        <td class="py-3">{{ $contract->contract_end }}</td>
                                        <td class="py-3">
                                            <span class="px-2 py-1 text-xs rounded-full
                                                @if($contract->status === 'Active') bg-green-100 text-green-700
                                                @elseif($contract->status === 'Terminated') bg-red-100 text-red-700
                                                @else bg-gray-100 text-gray-700 @endif">
                                                {{ $contract->status }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <div class="flex items-center gap-2">
                                                <button
                                                    @click="openEditModal({
                                                        id: {{ $contract->user->id }},
                                                        contractId: {{ $contract->id }},
                                                        name: '{{ $contract->user->name }}',
                                                        email: '{{ $contract->user->email }}',
                                                        phone: '{{ $contract->user->phone }}',
                                                        gender: '{{ $contract->user->gender }}',
                                                        room: '{{ $contract->room->name }}',
                                                        contractEnd: '{{ $contract->contract_end }}',
                                                        status: '{{ $contract->status }}'
                                                    })"
                                                    class="p-1.5 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                                    </svg>
                                                </button>
                                                <button
                                                    @click="openEarlyRemovalModal({
                                                        id: {{ $contract->user->id }},
                                                        contractId: {{ $contract->id }},
                                                        name: '{{ $contract->user->name }}',
                                                        contractEnd: '{{ $contract->contract_end }}'
                                                    })"
                                                    class="p-1.5 bg-yellow-100 hover:bg-yellow-200 text-yellow-600 rounded-lg">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="py-6 text-center text-gray-400">No residents found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <!-- REQUESTS MODAL -->
        <div x-show="showRequestsModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-[700px] max-h-[80vh] overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Requests</h3>
                    <button @click="showRequestsModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Tabs -->
                <div class="flex gap-2 mb-4">
                    <button
                        @click="requestTab = 'booking'"
                        :class="requestTab === 'booking' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600'"
                        class="px-4 py-2 text-sm rounded-lg font-semibold">
                        Room Bookings ({{ $bookingRequests->count() }})
                    </button>
                    <button
                        @click="requestTab = 'change'"
                        :class="requestTab === 'change' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600'"
                        class="px-4 py-2 text-sm rounded-lg font-semibold">
                        Room Change Requests ({{ $changeRequests->count() }})
                    </button>
                </div>

                <!-- Room Bookings Tab -->
                <div x-show="requestTab === 'booking'">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="pb-3 font-semibold">Name</th>
                                <th class="pb-3 font-semibold">Email</th>
                                <th class="pb-3 font-semibold">Room</th>
                                <th class="pb-3 font-semibold">Contract End</th>
                                <th class="pb-3 font-semibold">Date</th>
                                <th class="pb-3 font-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookingRequests as $req)
                                <tr class="border-b border-gray-100 dark:border-gray-700" id="booking-row-{{ $req->id }}">
                                    <td class="py-3">{{ $req->user->name }}</td>
                                    <td class="py-3">{{ $req->user->email }}</td>
                                    <td class="py-3">{{ $req->room->name }}</td>
                                    <td class="py-3">{{ str_replace('Contract end date: ', '', $req->reason) }}</td>
                                    <td class="py-3">{{ $req->created_at->format('M d, Y') }}</td>
                                    <td class="py-3">
                                        <div class="flex gap-2">
                                            <!-- APPROVE — now uses fetch instead of form POST -->
                                            <button
                                                @click="approveRequest({{ $req->id }}, '{{ $req->user->name }}', '{{ $req->room->name }}', 'booking')"
                                                class="px-3 py-1 text-xs bg-green-100 hover:bg-green-200 text-green-700 rounded-lg">
                                                Approve
                                            </button>
                                            <button
                                                @click="openRejectModal({{ $req->id }})"
                                                class="px-3 py-1 text-xs bg-red-100 hover:bg-red-200 text-red-700 rounded-lg">
                                                Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-center text-gray-400">No booking requests.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Room Change Requests Tab -->
                <div x-show="requestTab === 'change'">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="pb-3 font-semibold">Name</th>
                                <th class="pb-3 font-semibold">Current Room</th>
                                <th class="pb-3 font-semibold">Requested Room</th>
                                <th class="pb-3 font-semibold">Reason</th>
                                <th class="pb-3 font-semibold">Date</th>
                                <th class="pb-3 font-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($changeRequests as $req)
                                <tr class="border-b border-gray-100 dark:border-gray-700" id="change-row-{{ $req->id }}">
                                    <td class="py-3">{{ $req->user->name }}</td>
                                    <td class="py-3">
                                        @php
                                            $currentContract = \App\Models\Contract::where('user_id', $req->user_id)->where('status', 'Active')->with('room')->first();
                                        @endphp
                                        {{ $currentContract?->room?->name ?? '—' }}
                                    </td>
                                    <td class="py-3">{{ $req->room->name }}</td>
                                    <td class="py-3">{{ $req->reason ?? '—' }}</td>
                                    <td class="py-3">{{ $req->created_at->format('M d, Y') }}</td>
                                    <td class="py-3">
                                        <div class="flex gap-2">
                                            <!-- APPROVE — now uses fetch instead of form POST -->
                                            <button
                                                @click="approveRequest({{ $req->id }}, '{{ $req->user->name }}', '{{ $req->room->name }}', 'change')"
                                                class="px-3 py-1 text-xs bg-green-100 hover:bg-green-200 text-green-700 rounded-lg">
                                                Approve
                                            </button>
                                            <button
                                                @click="openRejectModal({{ $req->id }})"
                                                class="px-3 py-1 text-xs bg-red-100 hover:bg-red-200 text-red-700 rounded-lg">
                                                Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-center text-gray-400">No room change requests.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- APPROVAL SUCCESS DIALOGUE -->
        <div x-show="showApprovalSuccess" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 w-[400px] text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-green-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">Request Approved!</h3>
                <p class="text-sm text-gray-500 mb-1">
                    <strong x-text="approvedName"></strong>'s request has been approved.
                </p>
                <p class="text-sm text-gray-500 mb-6">
                    They have been assigned to room <strong x-text="approvedRoom"></strong>.
                </p>
                <button
                    @click="showApprovalSuccess = false; window.location.reload()"
                    class="w-full py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold text-sm">
                    OK, Got it!
                </button>
            </div>
        </div>

        <!-- EDIT MODAL -->
        <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-[500px]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Edit Resident</h3>
                    <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form :action="`/employee/residents/${selectedResident.id}/update`" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                            <input type="text" name="name" x-model="selectedResident.name"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                            <input type="email" name="email" x-model="selectedResident.email"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone</label>
                            <input type="text" name="phone" x-model="selectedResident.phone"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contract End</label>
                            <input type="date" name="contract_end" x-model="selectedResident.contractEnd"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" @click="showEditModal = false" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm bg-blue-500 hover:bg-blue-600 text-white rounded-lg">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- EARLY REMOVAL MODAL -->
        <div x-show="showEarlyRemovalModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-[500px]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Early Removal</h3>
                    <button @click="showEarlyRemovalModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4 mb-4">
                    <p class="text-sm text-yellow-700 dark:text-yellow-300">
                        ⚠️ You are removing <strong x-text="selectedResident.name"></strong> before their contract ends on <strong x-text="selectedResident.contractEnd"></strong>.
                    </p>
                </div>
                <form :action="`/employee/residents/${selectedResident.id}/early-removal`" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Reason</label>
                        <select name="end_reason" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <option value="early_termination">Early Termination</option>
                            <option value="non_payment">Non Payment</option>
                            <option value="violation">Violation</option>
                            <option value="voluntary_exit">Voluntary Exit</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reason / Remarks</label>
                        <textarea rows="3" name="reason" placeholder="Enter reason..."
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500"></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" @click="showEarlyRemovalModal = false" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg">Confirm Early Removal</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- REJECT REQUEST MODAL -->
        <div x-show="showRejectModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-[400px]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Reject Request</h3>
                    <button @click="showRejectModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form :action="`/employee/requests/${selectedRequestId}/reject`" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reason for Rejection</label>
                        <textarea rows="3" name="rejection_reason" placeholder="Enter reason for rejection..."
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" @click="showRejectModal = false" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm bg-red-500 hover:bg-red-600 text-white rounded-lg">Reject Request</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</x-employee-layout>

<script>
function residentsPage() {
    return {
        search: '',
        showRequestsModal: false,
        showEditModal: false,
        showEarlyRemovalModal: false,
        showRejectModal: false,
        showApprovalSuccess: false,
        requestTab: 'booking',
        selectedResident: {},
        selectedRequestId: null,
        approvedName: '',
        approvedRoom: '',

        openEditModal(resident) {
            this.selectedResident = { ...resident };
            this.showEditModal = true;
        },

        openEarlyRemovalModal(resident) {
            this.selectedResident = { ...resident };
            this.showEarlyRemovalModal = true;
        },

        openRejectModal(requestId) {
            this.selectedRequestId = requestId;
            this.showRejectModal = true;
        },

        approveRequest(requestId, residentName, roomName, type) {
            fetch(`/employee/requests/${requestId}/approve`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hide the approved row from the table
                    const row = document.getElementById(`${type}-row-${requestId}`);
                    if (row) row.remove();

                    // Close requests modal and show success dialogue
                    this.showRequestsModal = false;
                    this.approvedName = residentName;
                    this.approvedRoom = roomName;
                    this.showApprovalSuccess = true;
                } else {
                    alert(data.message || 'Something went wrong. Please try again.');
                }
            })
            .catch(() => {
                alert('Something went wrong. Please try again.');
            });
        },
    }
}
</script>
