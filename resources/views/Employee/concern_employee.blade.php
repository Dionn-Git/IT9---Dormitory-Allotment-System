<x-employee-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <span class="text-2xl">{{ __('Concerns') }}</span>
        </h2>
    </x-slot>

    <div x-data="concernsPage()">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex gap-6 h-[75vh]">

                    <!-- LEFT: Concerns List -->
                    <div class="w-1/3 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg flex flex-col">

                        <!-- Search -->
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                            <input
                                type="text"
                                x-model="search"
                                placeholder="Search concerns..."
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Filter Tabs -->
                        <div class="flex border-b border-gray-200 dark:border-gray-700">
                            <button
                                @click="filterStatus = 'all'"
                                :class="filterStatus === 'all' ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-500'"
                                class="flex-1 py-2 text-xs font-semibold">
                                All
                            </button>
                            <button
                                @click="filterStatus = 'Pending'"
                                :class="filterStatus === 'Pending' ? 'border-b-2 border-yellow-500 text-yellow-500' : 'text-gray-500'"
                                class="flex-1 py-2 text-xs font-semibold">
                                Pending
                            </button>
                            <button
                                @click="filterStatus = 'Acknowledged'"
                                :class="filterStatus === 'Acknowledged' ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-500'"
                                class="flex-1 py-2 text-xs font-semibold">
                                Acknowledged
                            </button>
                            <button
                                @click="filterStatus = 'Resolved'"
                                :class="filterStatus === 'Resolved' ? 'border-b-2 border-green-500 text-green-500' : 'text-gray-500'"
                                class="flex-1 py-2 text-xs font-semibold">
                                Resolved
                            </button>
                        </div>

                        <!-- Concerns List -->
                        <div class="flex-1 overflow-y-auto">
                            <template x-for="concern in filteredConcerns" :key="concern.id">
                                <div
                                    @click="selectConcern(concern)"
                                    class="p-4 border-b border-gray-100 dark:border-gray-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700"
                                    :class="selectedConcern.id === concern.id ? 'bg-blue-50 dark:bg-blue-900 border-l-4 border-l-blue-500' : ''">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-sm font-semibold text-white" x-text="concern.name"></p>
                                        <span
                                            class="text-xs px-2 py-0.5 rounded-full"
                                            :class="{
                                                'bg-yellow-100 text-yellow-700': concern.status === 'Pending',
                                                'bg-blue-100 text-blue-700': concern.status === 'Acknowledged',
                                                'bg-green-100 text-green-700': concern.status === 'Resolved'
                                            }"
                                            x-text="concern.status">
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 mb-1" x-text="concern.type"></p>
                                    <p class="text-xs text-gray-400 truncate" x-text="concern.description"></p>
                                    <p class="text-xs text-gray-300 mt-1" x-text="concern.date"></p>
                                </div>
                            </template>
                            <div x-show="filteredConcerns.length === 0" class="p-6 text-center text-gray-400 text-sm">
                                No concerns found.
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT: Messaging View -->
                    <div class="flex-1 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg flex flex-col">

                        <!-- No concern selected -->
                        <div x-show="!selectedConcern.id" class="flex-1 flex flex-col items-center justify-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-16 mb-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                            </svg>
                            <p class="text-sm">Select a concern to view the conversation</p>
                        </div>

                        <!-- Concern selected -->
                        <div x-show="selectedConcern.id" class="flex flex-col h-full">

                            <!-- Header -->
                            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-900 dark:text-gray-100" x-text="selectedConcern.name"></h3>
                                        <p class="text-xs text-gray-500">
                                            <span x-text="selectedConcern.type"></span> · Room <span x-text="selectedConcern.room"></span> · <span x-text="selectedConcern.date"></span>
                                        </p>
                                    </div>
                                    <!-- Status Selector -->
                                    <select
                                        x-model="selectedConcern.status"
                                        @change="updateStatus()"
                                        class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-1.5 text-xs dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="Pending">⏳ Pending</option>
                                        <option value="Acknowledged">✓ Acknowledged</option>
                                        <option value="Resolved">✅ Resolved</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Messages -->
                            <div class="flex-1 overflow-y-auto p-4 space-y-4" x-ref="messageContainer">

                                <!-- Student's original concern -->
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-bold shrink-0"
                                        x-text="selectedConcern.name ? selectedConcern.name.charAt(0) : ''">
                                    </div>
                                    <div class="max-w-[70%]">
                                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg rounded-tl-none p-3">
                                            <p class="text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1" x-text="selectedConcern.name"></p>
                                            <span
                                                class="text-xs px-2 py-0.5 rounded-full mb-2 inline-block"
                                                :class="{
                                                    'bg-blue-100 text-blue-700': selectedConcern.type === 'Room Damage',
                                                    'bg-purple-100 text-purple-700': selectedConcern.type === 'People',
                                                    'bg-gray-200 text-gray-700': selectedConcern.type === 'Other'
                                                }"
                                                x-text="selectedConcern.type">
                                            </span>
                                            <p class="text-sm text-gray-800 dark:text-gray-200" x-text="selectedConcern.description"></p>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1" x-text="selectedConcern.date"></p>
                                    </div>
                                </div>

                                <!-- Conversation messages -->
                                <template x-for="message in selectedConcern.messages" :key="message.id">
                                    <div
                                        class="flex items-start gap-3"
                                        :class="message.sender === 'landlord' ? 'flex-row-reverse' : ''">
                                        <div
                                            class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0"
                                            :class="message.sender === 'landlord' ? 'bg-green-500' : 'bg-blue-500'"
                                            x-text="message.sender === 'landlord' ? 'L' : (selectedConcern.name ? selectedConcern.name.charAt(0) : '')">
                                        </div>
                                        <div class="max-w-[70%]">
                                            <div
                                                class="rounded-lg p-3"
                                                :class="message.sender === 'landlord'
                                                    ? 'bg-green-500 text-white rounded-tr-none'
                                                    : 'bg-gray-100 dark:bg-gray-700 rounded-tl-none'">
                                                <p
                                                    class="text-sm"
                                                    :class="message.sender === 'landlord' ? 'text-white' : 'text-gray-800 dark:text-gray-200'"
                                                    x-text="message.text">
                                                </p>
                                            </div>
                                            <p
                                                class="text-xs text-gray-400 mt-1"
                                                :class="message.sender === 'landlord' ? 'text-right' : ''"
                                                x-text="message.time">
                                            </p>
                                        </div>
                                    </div>
                                </template>

                            </div>

                            <!-- Reply Box -->
                            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-end gap-3">
                                    <textarea
                                        x-model="replyText"
                                        rows="2"
                                        placeholder="Type your reply..."
                                        @keydown.enter.prevent="sendReply()"
                                        class="flex-1 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">
                                    </textarea>
                                    <button
                                        @click="sendReply()"
                                        class="p-2.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Press Enter to send</p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-employee-layout>

<script>
function concernsPage() {
    return {
        search: '',
        filterStatus: 'all',
        replyText: '',
        selectedConcern: {},

        concerns: [
            {
                id: 1,
                name: 'Juan Dela Cruz',
                room: '101',
                type: 'Room Damage',
                description: 'The ceiling fan in my room is broken and making a loud noise.',
                date: '2026-04-15',
                status: 'Acknowledged',
                messages: [
                    { id: 1, sender: 'landlord', text: 'Thank you for reporting this. We will send someone to check it on April 17.', time: '2026-04-15 10:30 AM' },
                    { id: 2, sender: 'student', text: 'Thank you! I will be available in the afternoon.', time: '2026-04-15 11:00 AM' },
                ]
            },
            {
                id: 2,
                name: 'Maria Santos',
                room: '202',
                type: 'People',
                description: 'My roommate is being too loud at night and disturbing my sleep.',
                date: '2026-04-16',
                status: 'Pending',
                messages: []
            },
            {
                id: 3,
                name: 'Pedro Reyes',
                room: '103',
                type: 'Other',
                description: 'The wifi in my room is very slow and keeps disconnecting.',
                date: '2026-04-10',
                status: 'Resolved',
                messages: [
                    { id: 1, sender: 'landlord', text: 'We have replaced the wifi router. Please let us know if the issue persists.', time: '2026-04-11 09:00 AM' },
                    { id: 2, sender: 'student', text: 'It is working now, thank you!', time: '2026-04-11 10:00 AM' },
                ]
            },
        ],

        get filteredConcerns() {
            return this.concerns.filter(c => {
                const matchSearch = !this.search ||
                    c.name.toLowerCase().includes(this.search.toLowerCase()) ||
                    c.type.toLowerCase().includes(this.search.toLowerCase()) ||
                    c.description.toLowerCase().includes(this.search.toLowerCase());
                const matchStatus = this.filterStatus === 'all' || c.status === this.filterStatus;
                return matchSearch && matchStatus;
            });
        },

        selectConcern(concern) {
            this.selectedConcern = concern;
            this.replyText = '';
            this.$nextTick(() => {
                const container = this.$refs.messageContainer;
                if (container) container.scrollTop = container.scrollHeight;
            });
        },

        sendReply() {
            if (this.replyText.trim() === '') return;
            if (!this.selectedConcern.messages) this.selectedConcern.messages = [];
            this.selectedConcern.messages.push({
                id: Date.now(),
                sender: 'landlord',
                text: this.replyText.trim(),
                time: new Date().toLocaleString(),
            });
            // Auto set to Acknowledged if still Pending
            if (this.selectedConcern.status === 'Pending') {
                this.selectedConcern.status = 'Acknowledged';
            }
            this.replyText = '';
            this.$nextTick(() => {
                const container = this.$refs.messageContainer;
                if (container) container.scrollTop = container.scrollHeight;
            });
        },

        updateStatus() {
            const index = this.concerns.findIndex(c => c.id === this.selectedConcern.id);
            if (index !== -1) {
                this.concerns[index].status = this.selectedConcern.status;
            }
        },
    }
}
</script>