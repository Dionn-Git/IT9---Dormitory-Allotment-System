<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomRequest;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
        public function index()
    {
        $user = Auth::user();

        $activeContract = Contract::where('user_id', $user->id)
                            ->where('status', 'Active')
                            ->with('room')
                            ->first();

        $pendingRequest = RoomRequest::where('user_id', $user->id)
                            ->where('status', 'Pending')
                            ->with('room')
                            ->first();

        // Get all available rooms individually
        $rooms = Room::where('status', 'Available')->get();

        return view('Student.rooms_student', compact(
            'rooms',
            'activeContract',
            'pendingRequest'
        ));
    }

        public function requestRoom(Request $request)
    {
        $request->validate([
            'room_id'      => 'required|exists:rooms,id',
            'contract_end' => 'required|date|after:today',
        ]);

        $user = Auth::user();
        $room = Room::findOrFail($request->room_id);

        // Check if user already has active contract
        $activeContract = Contract::where('user_id', $user->id)
                            ->where('status', 'Active')
                            ->first();

        if ($activeContract) {
            return response()->json(['success' => false, 'message' => 'You already have an active room contract.']);
        }

        // Check if user already has pending request
        $existingRequest = RoomRequest::where('user_id', $user->id)
                            ->where('status', 'Pending')
                            ->first();

        if ($existingRequest) {
            return response()->json(['success' => false, 'message' => 'You already have a pending room request.']);
        }

        // Check capacity
        if (!$room->hasAvailableSpace()) {
            return response()->json(['success' => false, 'message' => 'This room is already full.']);
        }

        // Create request
        RoomRequest::create([
            'user_id'      => $user->id,
            'room_id'      => $request->room_id,
            'request_type' => 'booking',
            'status'       => 'Pending',
            'reason'       => 'Contract end date: ' . $request->contract_end,
        ]);

        // Update room status to reserved
        $room->update(['status' => 'Reserved']);

        return response()->json(['success' => true]);
    }
}