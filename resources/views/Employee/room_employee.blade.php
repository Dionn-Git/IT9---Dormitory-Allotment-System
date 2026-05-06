<x-employee-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <span class="text-2xl">{{ __('Rooms') }}</span>
        </h2>
    </x-slot>

    <!-- SINGLE x-data wrapper for EVERYTHING -->
    <div x-data="roomsPage()">

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

                <!-- Top Bar -->
                <div class="flex items-center justify-between mb-6">
                    <input
                        type="text"
                        x-model="search"
                        placeholder="Search room..."
                        class="w-1/3 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div class="flex gap-3">
                        <button
                            @click="viewMode = viewMode === 'grid' ? 'list' : 'grid'"
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg">
                            <span x-text="viewMode === 'grid' ? 'List View' : 'Grid View'"></span>
                        </button>
                        <button
                            @click="openAddModal()"
                            class="flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Add Room
                        </button>
                    </div>
                </div>

                <!-- ROOM TYPE SUMMARY CARDS -->
                <div class="grid grid-cols-4 gap-4 mb-6">
                    @php
                        $typeColors = [
                            'Single' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon' => 'bg-blue-100'],
                            'Double' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-200', 'icon' => 'bg-green-100'],
                            'Triple' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'border' => 'border-yellow-200', 'icon' => 'bg-yellow-100'],
                            'Quad'   => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-200', 'icon' => 'bg-purple-100'],
                        ];
                        $typeCapacity = ['Single' => 1, 'Double' => 2, 'Triple' => 3, 'Quad' => 4];
                        $allTypes = ['Single', 'Double', 'Triple', 'Quad'];
                    @endphp

                    @foreach($allTypes as $type)
                        @php
                            $color = $typeColors[$type];
                            $typeRooms = $rooms->where('type', $type);
                            $totalRooms = $typeRooms->count();
                            $availableRooms = $typeRooms->where('status', 'Available')->count();
                            $occupiedRooms = $typeRooms->where('status', 'Occupied')->count();
                            $reservedRooms = $typeRooms->where('status', 'Reserved')->count();
                            $minPrice = $typeRooms->min('price');
                        @endphp
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border {{ $color['border'] }}">
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="{{ $color['icon'] }} p-2 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 {{ $color['text'] }}">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                        </svg>
                                    </div>
                                    <span class="text-2xl font-bold {{ $color['text'] }}">{{ $totalRooms }}</span>
                                </div>
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">{{ $type }} Room</h3>
                                <p class="text-xs text-gray-500 mb-2">{{ $typeCapacity[$type] }} person(s) per room</p>
                                @if($minPrice)
                                    <p class="text-xs text-gray-500 mb-2">From ₱{{ number_format($minPrice, 2) }}/month</p>
                                @endif
                                <div class="flex gap-2 text-xs">
                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full">{{ $availableRooms }} Available</span>
                                    <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full">{{ $occupiedRooms }} Occupied</span>
                                    @if($reservedRooms > 0)
                                        <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded-full">{{ $reservedRooms }} Reserved</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- INDIVIDUAL ROOMS TABLE/GRID -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">All Rooms</h3>

                        <!-- TABLE VIEW -->
                        <div x-show="viewMode === 'list'">
                            <table class="w-full text-sm text-left">
                                <thead>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th class="pb-3 font-semibold">#</th>
                                        <th class="pb-3 font-semibold">Room Name</th>
                                        <th class="pb-3 font-semibold">Type</th>
                                        <th class="pb-3 font-semibold">Floor</th>
                                        <th class="pb-3 font-semibold">Capacity</th>
                                        <th class="pb-3 font-semibold">Occupants</th>
                                        <th class="pb-3 font-semibold">Price</th>
                                        <th class="pb-3 font-semibold">Status</th>
                                        <th class="pb-3 font-semibold">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rooms as $index => $room)
                                        <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700"
                                            x-show="!search || '{{ strtolower($room->name) }}'.includes(search.toLowerCase()) || '{{ strtolower($room->type) }}'.includes(search.toLowerCase())">
                                            <td class="py-3">{{ $index + 1 }}</td>
                                            <td class="py-3 font-medium">{{ $room->name }}</td>
                                            <td class="py-3">{{ $room->type }}</td>
                                            <td class="py-3">{{ $room->floor }}</td>
                                            <td class="py-3">{{ $room->capacity }}</td>
                                            <td class="py-3">{{ $room->current_occupants }}/{{ $room->capacity }}</td>
                                            <td class="py-3">₱{{ number_format($room->price, 2) }}</td>
                                            <td class="py-3">
                                                <span class="px-2 py-1 text-xs rounded-full
                                                    @if($room->status === 'Available') bg-green-100 text-green-700
                                                    @elseif($room->status === 'Occupied') bg-red-100 text-red-700
                                                    @elseif($room->status === 'Reserved') bg-yellow-100 text-yellow-700
                                                    @else bg-gray-100 text-gray-700 @endif">
                                                    {{ $room->status }}
                                                </span>
                                            </td>
                                            <td class="py-3">
                                                <div class="flex gap-2">
                                                    <button
                                                        @click="openEditModal(@js($room))"
                                                        class="p-1.5 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                                        </svg>
                                                    </button>
                                                    <form method="POST" action="{{ route('employee.rooms.destroy', $room->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            onclick="return confirm('Are you sure you want to delete this room?')"
                                                            class="p-1.5 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="py-6 text-center text-gray-400">No rooms found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- GRID VIEW -->
                        <div x-show="viewMode === 'grid'" class="grid grid-cols-4 gap-4">
                            @forelse($rooms as $room)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden"
                                    x-show="!search || '{{ strtolower($room->name) }}'.includes(search.toLowerCase()) || '{{ strtolower($room->type) }}'.includes(search.toLowerCase())">
                                    @if($room->image)
                                        <img src="{{ Storage::url($room->image) }}" alt="{{ $room->name }}" class="w-full h-32 object-cover">
                                    @else
                                        <div class="w-full h-32 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-gray-400">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="p-3">
                                        <div class="flex items-center justify-between mb-1">
                                            <h4 class="font-semibold text-sm">{{ $room->name }}</h4>
                                            <span class="text-xs px-2 py-0.5 rounded-full
                                                @if($room->status === 'Available') bg-green-100 text-green-700
                                                @elseif($room->status === 'Occupied') bg-red-100 text-red-700
                                                @else bg-yellow-100 text-yellow-700 @endif">
                                                {{ $room->status }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500">{{ $room->type }} · {{ $room->floor }}</p>
                                        <p class="text-xs text-gray-500">{{ $room->current_occupants }}/{{ $room->capacity }} occupants</p>
                                        <p class="text-xs font-semibold text-blue-600 mt-1">₱{{ number_format($room->price, 2) }}/month</p>
                                        <div class="flex gap-1 mt-2">
                                            <button
                                                @click="openEditModal(@js($room))"
                                                class="flex-1 py-1 text-xs bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg">
                                                Edit
                                            </button>
                                            <form method="POST" action="{{ route('employee.rooms.destroy', $room->id) }}" class="flex-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Delete this room?')"
                                                    class="w-full py-1 text-xs bg-red-100 hover:bg-red-200 text-red-700 rounded-lg">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-4 py-12 text-center text-gray-400">No rooms found.</div>
                            @endforelse
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- ADD ROOM MODAL — inside the SAME x-data wrapper -->
        <div
            x-show="showAddModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-[550px] max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Add Room</h3>
                    <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('employee.rooms.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">

                        <!-- Room Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Room Type</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="type" value="Single" class="peer sr-only" required>
                                    <div class="border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 rounded-lg p-3 text-center transition">
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">Single Room</p>
                                        <p class="text-xs text-gray-500">1 person</p>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="type" value="Double" class="peer sr-only">
                                    <div class="border-2 border-gray-200 peer-checked:border-green-500 peer-checked:bg-green-50 rounded-lg p-3 text-center transition">
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">Double Room</p>
                                        <p class="text-xs text-gray-500">2 persons</p>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="type" value="Triple" class="peer sr-only">
                                    <div class="border-2 border-gray-200 peer-checked:border-yellow-500 peer-checked:bg-yellow-50 rounded-lg p-3 text-center transition">
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">Triple Room</p>
                                        <p class="text-xs text-gray-500">3 persons</p>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="type" value="Quad" class="peer sr-only">
                                    <div class="border-2 border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 rounded-lg p-3 text-center transition">
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">Quad Room</p>
                                        <p class="text-xs text-gray-500">4 persons</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Number of Rooms to Add -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Number of Rooms to Add</label>
                            <input type="number" name="quantity" value="1" min="1" max="50"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-400 mt-1">Room names will be auto-generated (e.g. S-001, D-001)</p>
                        </div>

                        <!-- Floor -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Floor</label>
                            <select name="floor" required
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select floor</option>
                                <option value="1st Floor">1st Floor</option>
                                <option value="2nd Floor">2nd Floor</option>
                                <option value="3rd Floor">3rd Floor</option>
                                <option value="4th Floor">4th Floor</option>
                            </select>
                        </div>

                        <!-- Price -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price per Month (₱)</label>
                            <input type="number" name="price" placeholder="e.g. 3000" min="0" required
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                            <select name="status" required
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="Available">Available</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                            <textarea name="description" rows="2" placeholder="Enter room description..."
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>

                        <!-- Inclusions -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">What's Included</label>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach(['WiFi', 'Water', 'Electricity', 'Bed', 'Cabinet', 'Own Bathroom', 'Aircon', 'Fan', 'Desk', 'Closet'] as $inclusion)
                                    <label class="flex items-center gap-2 cursor-pointer p-2 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <input type="checkbox" name="inclusions[]" value="{{ $inclusion }}" class="rounded text-blue-500">
                                        <span class="text-sm">{{ $inclusion }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <div class="mt-2">
                                <input type="text" name="inclusions_other" placeholder="Other inclusions (comma separated)..."
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-400 mt-1">e.g. Kitchen, Parking, Garden</p>
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Room Image</label>
                            <div
                                class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center cursor-pointer hover:border-blue-400 transition"
                                @click="$refs.addImageInput.click()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 mx-auto text-gray-400 mb-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                                <p class="text-sm text-gray-500" x-text="addImageName || 'Click to upload image'"></p>
                                <p class="text-xs text-gray-400 mt-1">PNG, JPG, JPEG up to 5MB</p>
                            </div>
                            <input
                                type="file"
                                name="image"
                                x-ref="addImageInput"
                                accept="image/*"
                                class="hidden"
                                @change="addImageName = $event.target.files[0]?.name">
                        </div>

                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" @click="showAddModal = false" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm bg-blue-500 hover:bg-blue-600 text-white rounded-lg">Add Room</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- EDIT ROOM MODAL — inside the SAME x-data wrapper -->
        <div
            x-show="showEditModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-[550px] max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Edit Room — <span x-text="editRoom.name"></span></h3>
                    <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form :action="`/employee/rooms/${editRoom.id}`" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">

                        <!-- Room Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Room Type</label>
                            <div class="grid grid-cols-2 gap-3">
                                <template x-for="t in ['Single', 'Double', 'Triple', 'Quad']" :key="t">
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="type" :value="t" :checked="editRoom.type === t" class="peer sr-only">
                                        <div class="border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 rounded-lg p-3 text-center transition">
                                            <p class="font-semibold text-gray-900 dark:text-gray-100" x-text="t + ' Room'"></p>
                                        </div>
                                    </label>
                                </template>
                            </div>
                        </div>

                        <!-- Floor -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Floor</label>
                            <select name="floor" required
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="1st Floor" :selected="editRoom.floor === '1st Floor'">1st Floor</option>
                                <option value="2nd Floor" :selected="editRoom.floor === '2nd Floor'">2nd Floor</option>
                                <option value="3rd Floor" :selected="editRoom.floor === '3rd Floor'">3rd Floor</option>
                                <option value="4th Floor" :selected="editRoom.floor === '4th Floor'">4th Floor</option>
                            </select>
                        </div>

                        <!-- Price -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price per Month (₱)</label>
                            <input type="number" name="price" :value="editRoom.price" min="0" required
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                            <select name="status" required
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="Available" :selected="editRoom.status === 'Available'">Available</option>
                                <option value="Occupied" :selected="editRoom.status === 'Occupied'">Occupied</option>
                                <option value="Reserved" :selected="editRoom.status === 'Reserved'">Reserved</option>
                                <option value="Maintenance" :selected="editRoom.status === 'Maintenance'">Maintenance</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                            <textarea name="description" rows="2" :value="editRoom.description"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>

                        <!-- Inclusions -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">What's Included</label>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach(['WiFi', 'Water', 'Electricity', 'Bed', 'Cabinet', 'Own Bathroom', 'Aircon', 'Fan', 'Desk', 'Closet'] as $inclusion)
                                    <label class="flex items-center gap-2 cursor-pointer p-2 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <input type="checkbox" name="inclusions[]" value="{{ $inclusion }}"
                                            :checked="editRoom.inclusions && editRoom.inclusions.includes('{{ $inclusion }}')"
                                            class="rounded text-blue-500">
                                        <span class="text-sm">{{ $inclusion }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <div class="mt-2">
                                <input type="text" name="inclusions_other" placeholder="Other inclusions (comma separated)..."
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <!-- Image -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Room Image (leave empty to keep current)</label>
                            <input type="file" name="image" accept="image/*"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100">
                        </div>

                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" @click="showEditModal = false" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm bg-blue-500 hover:bg-blue-600 text-white rounded-lg">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

    </div><!-- END single x-data wrapper -->

</x-employee-layout>

<script>
function roomsPage() {
    return {
        search: '',
        viewMode: 'list',
        showAddModal: false,
        showEditModal: false,
        editRoom: {},
        addImageName: '',
        addImagePreview: '',

        openAddModal() {
            this.addImageName = '';
            this.addImagePreview = '';
            this.showAddModal = true;
        },

        openEditModal(room) {
            this.editRoom = JSON.parse(JSON.stringify(room));
            this.showEditModal = true;
        }
    }
}
</script>
