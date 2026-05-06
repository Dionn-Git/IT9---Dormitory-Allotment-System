<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Dormitory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandlordRoomController extends Controller
{
    public function index()
    {
        $roomTypes = Room::selectRaw('type, count(*) as total,
                        sum(case when status = "Available" then 1 else 0 end) as available,
                        sum(case when status = "Occupied" then 1 else 0 end) as occupied,
                        sum(case when status = "Reserved" then 1 else 0 end) as reserved,
                        MIN(price) as min_price,
                        MAX(price) as max_price,
                        capacity')
                    ->groupBy('type', 'capacity')
                    ->get();

        $rooms = Room::latest()->get();

        return view('Employee.room_employee', compact('rooms', 'roomTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'        => 'required|string|in:Single,Double,Triple,Quad',
            'floor'       => 'required|string',
            'price'       => 'required|numeric|min:0',
            'status'      => 'required|string',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:5120',
            'quantity'    => 'required|integer|min:1|max:50',
        ]);

        $dormitory = Dormitory::first();

        if (!$dormitory) {
            return back()->withErrors(['error' => 'No dormitory found. Please set up the dormitory first.']);
        }

        $capacityMap = [
            'Single' => 1,
            'Double' => 2,
            'Triple' => 3,
            'Quad'   => 4,
        ];

        $capacity = $capacityMap[$request->type];

        // Merge checkbox inclusions and custom input
        $inclusions = $request->input('inclusions', []);
        if ($request->filled('inclusions_other')) {
            $others = array_map('trim', explode(',', $request->inclusions_other));
            $inclusions = array_merge($inclusions, array_filter($others));
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rooms', 'public');
        }

        // Use MAX id-based number instead of count() to avoid duplicate names after deletion
        $prefix = strtoupper(substr($request->type, 0, 1));
        $lastRoom = Room::where('type', $request->type)->orderByDesc('id')->first();
        $lastNumber = 0;

        if ($lastRoom) {
            // Extract number from name like "S-003" → 3
            preg_match('/(\d+)$/', $lastRoom->name, $matches);
            $lastNumber = isset($matches[1]) ? (int) $matches[1] : 0;
        }

        for ($i = 1; $i <= $request->quantity; $i++) {
            $roomNumber = $lastNumber + $i;
            $roomName = $prefix . '-' . str_pad($roomNumber, 3, '0', STR_PAD_LEFT);

            Room::create([
                'dormitory_id'      => $dormitory->id,
                'name'              => $roomName,
                'type'              => $request->type,
                'floor'             => $request->floor,
                'capacity'          => $capacity,
                'current_occupants' => 0,
                'price'             => $request->price,
                'status'            => $request->status,
                'description'       => $request->description,
                'inclusions'        => $inclusions,
                'image'             => $imagePath,
            ]);
        }

        return back()->with('success', $request->quantity . ' ' . $request->type . ' room(s) added successfully.');
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'type'        => 'required|string|in:Single,Double,Triple,Quad',
            'floor'       => 'required|string',
            'price'       => 'required|numeric|min:0',
            'status'      => 'required|string',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:5120',
        ]);

        $capacityMap = [
            'Single' => 1,
            'Double' => 2,
            'Triple' => 3,
            'Quad'   => 4,
        ];

        // Merge inclusions
        $inclusions = $request->input('inclusions', []);
        if ($request->filled('inclusions_other')) {
            $others = array_map('trim', explode(',', $request->inclusions_other));
            $inclusions = array_merge($inclusions, array_filter($others));
        }

        if ($request->hasFile('image')) {
            if ($room->image) {
                Storage::disk('public')->delete($room->image);
            }
            $room->image = $request->file('image')->store('rooms', 'public');
        }

        $room->update([
            'type'        => $request->type,
            'floor'       => $request->floor,
            'capacity'    => $capacityMap[$request->type] ?? $room->capacity,
            'price'       => $request->price,
            'status'      => $request->status,
            'description' => $request->description,
            'inclusions'  => $inclusions,
            'image'       => $room->image,
        ]);

        return back()->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }
        $room->delete();
        return back()->with('success', 'Room deleted successfully.');
    }
}