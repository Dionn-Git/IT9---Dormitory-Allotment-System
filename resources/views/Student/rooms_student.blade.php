    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <span class="text-2xl">{{ __('Rooms') }}</span>
            </h2>
        </x-slot>

        <!-- SINGLE x-data wrapper for EVERYTHING -->
        <div x-data="{
            showBookModal: false,
            showSuccessModal: false,
            selectedRoom: { inclusions: [] },
            contractEnd: '',
            tomorrow: new Date(Date.now() + 86400000).toISOString().split('T')[0],

            openBookModal(room) {
                this.selectedRoom = room;
                this.showBookModal = true;
            },

            submitBooking() {
                if (!this.contractEnd) return alert('Select date');

                fetch('{{ route("rooms.request") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    },
                    body: JSON.stringify({
                        room_id: this.selectedRoom.id,
                        contract_end: this.contractEnd
                    })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        this.showBookModal = false;
                        this.showSuccessModal = true;
                    }
                });
            }
        }">

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

                    <!-- Pending Request Notice -->
                    @if($pendingRequest)
                        <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4 flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-yellow-500 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-yellow-700">Room Request Pending</p>
                                <p class="text-xs text-yellow-600">Your request for <strong>{{ $pendingRequest->room->name }}</strong> is waiting for landlord approval. You will be notified once approved.</p>
                            </div>
                        </div>
                    @endif

                    <!-- Current Room Display -->
                    @if($activeContract)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                            <div class="flex">
                                @if($activeContract->room->image)
                                    <img src="{{ Storage::url($activeContract->room->image) }}" alt="Current Room" class="w-64 h-48 object-cover">
                                @else
                                    <div class="w-64 h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col justify-center">
                                    <h2 class="text-2xl font-bold mb-4">Your Current Room</h2>
                                    <div class="flex gap-10">
                                        <div>
                                            <p class="text-sm text-gray-500">Room Name</p>
                                            <p class="text-lg font-semibold">{{ $activeContract->room->name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Type</p>
                                            <p class="text-lg font-semibold">{{ $activeContract->room->type }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Monthly Rate</p>
                                            <p class="text-lg font-semibold">₱{{ number_format($activeContract->monthly_rate, 2) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Contract End</p>
                                            <p class="text-lg font-semibold">{{ $activeContract->contract_end }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Status</p>
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Active</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Available Rooms -->
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Available Rooms</h3>

                    @if($rooms->count() === 0)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-12 text-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-16 mx-auto mb-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                            </svg>
                            <p class="text-sm">No rooms available at the moment.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-3 gap-6">
                            @foreach($rooms as $room)
                                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                                    @if($room->image)
                                        <img src="{{ Storage::url($room->image) }}" alt="{{ $room->name }}" class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 text-gray-300">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $room->name }}</h3>
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">Available</span>
                                        </div>

                                        <p class="text-sm text-gray-500 mb-1">Type: {{ $room->type }}</p>
                                        <p class="text-sm text-gray-500 mb-1">Floor: {{ $room->floor }}</p>
                                        <p class="text-sm text-gray-500 mb-1">Capacity: {{ $room->capacity }} Person(s)</p>
                                        <p class="text-sm font-semibold text-blue-600 mb-3">₱{{ number_format($room->price, 2) }}/month</p>

                                        @if($room->description)
                                            <p class="text-xs text-gray-400 mb-3">{{ $room->description }}</p>
                                        @endif

                                        @if($room->inclusions && count($room->inclusions) > 0)
                                            <div class="mb-3 flex flex-wrap gap-1">
                                                @foreach($room->inclusions as $inclusion)
                                                    <span class="px-2 py-0.5 text-xs bg-blue-50 text-blue-700 rounded-full">{{ $inclusion }}</span>
                                                @endforeach
                                            </div>
                                        @endif

                                        @if(!$activeContract && !$pendingRequest)
                                            <button 
                                                @click="openBookModal({
                                                    id: {{ $room->id }},
                                                    name: @js($room->name),
                                                    type: @js($room->type),
                                                    price: {{ $room->price }},
                                                    description: @js($room->description),
                                                    image: {{ $room->image ? "'" . Storage::url($room->image) . "'" : "null" }},
                                                    inclusions: @js($room->inclusions ?? [])
                                                })"
                                                 class="w-full py-2 text-sm bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-semibold">
                                                    Book
                                            </button>
                                        @elseif($activeContract)
                                            <button disabled class="w-full py-2 text-sm bg-gray-200 text-gray-400 rounded-lg font-semibold cursor-not-allowed">
                                                Already Have a Room
                                            </button>
                                        @elseif($pendingRequest)
                                            <button disabled class="w-full py-2 text-sm bg-yellow-100 text-yellow-600 rounded-lg font-semibold cursor-not-allowed">
                                                Request Pending
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>

            <!-- BOOK ROOM MODAL — inside the SAME x-data wrapper -->
            <div
                x-show="showBookModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                x-cloak>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-[700px] overflow-hidden">
                    <div class="flex">
                        <!-- Left: Image -->
                        <div class="w-64 shrink-0">
                            <template x-if="selectedRoom.image">
                                <img :src="selectedRoom.image" alt="Room" class="w-full h-full min-h-[350px] object-cover">
                            </template>
                            <template x-if="!selectedRoom.image">
                                <div class="w-full min-h-[350px] bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                    </svg>
                                </div>
                            </template>
                        </div>

                        <!-- Right: Details -->
                        <div class="flex-1 p-6 flex flex-col">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100" x-text="selectedRoom.name"></h3>
                                <button @click="showBookModal = false" class="text-gray-400 hover:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Room Type</span>
                                    <span class="font-semibold" x-text="selectedRoom.type"></span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Monthly Price</span>
                                    <span class="font-semibold text-blue-600">₱<span x-text="Number(selectedRoom.price).toLocaleString()"></span></span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Description</span>
                                    <span class="font-semibold text-right max-w-[200px]" x-text="selectedRoom.description || 'No description'"></span>
                                </div>
                            </div>

                            <!-- Inclusions -->
                            <div class="mb-4">
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">What's Included:</p>
                                <div class="flex flex-wrap gap-2">
                                    <template x-for="inclusion in selectedRoom.inclusions" :key="inclusion">
                                        <span class="px-2 py-1 text-xs bg-blue-50 text-blue-700 rounded-full" x-text="inclusion"></span>
                                    </template>
                                    <span x-show="!selectedRoom.inclusions || selectedRoom.inclusions.length === 0" class="text-xs text-gray-400">No inclusions listed</span>
                                </div>
                            </div>

                            <!-- Contract End Date -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contract End Date</label>
                                <input
                                    type="date"
                                    x-model="contractEnd"
                                    :min="tomorrow"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-400 mt-1">Select when your contract will end</p>
                            </div>

                            <div class="mt-auto">
                                <button
                                    @click="submitBooking()"
                                    class="w-full py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-semibold text-sm">
                                    Book This Room
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SUCCESS MODAL — inside the SAME x-data wrapper -->
            <div
                x-show="showSuccessModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                x-cloak>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 w-[400px] text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-green-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">Request Submitted!</h3>
                    <p class="text-sm text-gray-500 mb-6">Your room booking request has been submitted. Please wait for the landlord to approve. You will be notified once approved.</p>
                    <button
                        @click="showSuccessModal = false; window.location.reload()"
                        class="w-full py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-semibold text-sm">
                        OK, Got it!
                    </button>
                </div>
            </div>

        </div><!-- END single x-data wrapper -->

    </x-app-layout>
    @push('scripts')    
    <script>
    function roomsPage() {
        return {
            showBookModal: false,
            showSuccessModal: false,

            selectedRoom: {}, // ✅ use ONE variable only
            contractEnd: '',
            tomorrow: new Date(Date.now() + 86400000).toISOString().split('T')[0],

            openBookModal(room) {
                if (!room) return;
                this.selectedRoom = { ...room }; // ✅ FIXED
                this.showBookModal = true;
            }, // ✅ ← YOU WERE MISSING THIS COMMA

            submitBooking() {
                if (!this.contractEnd) {
                    alert('Please select a contract end date.');
                    return;
                }

                fetch('{{ route("rooms.request") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        room_id: this.selectedRoom.id, // ✅ now works
                        contract_end: this.contractEnd,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.showBookModal = false;
                        this.showSuccessModal = true;
                    } else {
                        alert(data.message || 'Something went wrong.');
                    }
                })
                .catch(() => alert('Something went wrong.'));
            }
        }
    }
    </script>
    @endpush

