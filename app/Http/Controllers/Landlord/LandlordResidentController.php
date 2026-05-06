<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Contract;
use App\Models\Room;
use App\Models\RoomRequest;
use App\Models\ResidentHistory;
use App\Models\Notification;
use Illuminate\Http\Request;

class LandlordResidentController extends Controller
{
            public function index()
    {
        $residents = Contract::with('user', 'room')
                        ->where('status', 'Active')
                        ->get();

        $bookingRequests = RoomRequest::with('user', 'room')
                        ->where('request_type', 'booking')
                        ->where('status', 'Pending')
                        ->latest()
                        ->get();

        $changeRequests = RoomRequest::with('user', 'room')
                        ->where('request_type', 'room_change')
                        ->where('status', 'Pending')
                        ->latest()
                        ->get();

        return view('Employee.residents_employee', compact(
            'residents',
            'bookingRequests',
            'changeRequests'
        ));
    }

    public function requests()
    {
        $bookings = RoomRequest::with('user', 'room')
                        ->where('request_type', 'booking')
                        ->where('status', 'Pending')
                        ->get();

        $roomChanges = RoomRequest::with('user', 'room')
                        ->where('request_type', 'room_change')
                        ->where('status', 'Pending')
                        ->get();

        return view('Employee.requests', compact('bookings', 'roomChanges'));
    }

        public function approveRequest(Request $request, RoomRequest $roomRequest)
        {
            $room = Room::findOrFail($roomRequest->room_id);

            // Check capacity
            if (!$room->hasAvailableSpace()) {
                return response()->json(['success' => false, 'message' => 'Room is already full.']);
            }

            // Extract contract end from reason
            $contractEnd = str_replace('Contract end date: ', '', $roomRequest->reason);

            // Create contract
            Contract::create([
                'user_id'         => $roomRequest->user_id,
                'room_id'         => $roomRequest->room_id,
                'contract_start'  => now()->format('Y-m-d'),
                'contract_end'    => $contractEnd,
                'monthly_rate'    => $room->price,
                'payment_due_day' => 1,
                'status'          => 'Active',
            ]);

            // Update room occupants and status
            $room->increment('current_occupants');
            $room->updateStatus();

            // Update request status
            $roomRequest->update(['status' => 'Approved']);

            // Send notification to student
            Notification::create([
                'user_id' => $roomRequest->user_id,
                'title'   => 'Room Request Approved! 🎉',
                'message' => 'Your room booking request for ' . $room->name . ' has been approved! You may move in anytime. Your contract starts today and ends on ' . $contractEnd . '.',
                'type'    => 'request',
                'is_read' => false,
            ]);

            return response()->json(['success' => true]); // ← changed from back()->with(...)
        }

    public function rejectRequest(Request $request, RoomRequest $roomRequest)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $roomRequest->update([
            'status'           => 'Rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Notify student
        Notification::create([
            'user_id' => $roomRequest->user_id,
            'title'   => 'Room Request Rejected',
            'message' => 'Your room request has been rejected. Reason: ' . $request->rejection_reason,
            'type'    => 'request',
        ]);

        return back()->with('success', 'Request rejected.');
    }

    public function earlyRemoval(Request $request, $userId)
    {
        $request->validate([
            'reason'   => 'required|string',
            'end_reason' => 'required|string',
        ]);

        $contract = Contract::where('user_id', $userId)
                        ->where('status', 'Active')
                        ->firstOrFail();

        // Log to resident history
        ResidentHistory::create([
            'user_id'        => $userId,
            'room_id'        => $contract->room_id,
            'contract_id'    => $contract->id,
            'contract_start' => $contract->contract_start,
            'contract_end'   => $contract->contract_end,
            'monthly_rate'   => $contract->monthly_rate,
            'end_reason'     => $request->end_reason,
            'remarks'        => $request->reason,
            'moved_out_at'   => now(),
        ]);

        // Update room occupants
        $room = Room::findOrFail($contract->room_id);
        $room->decrement('current_occupants');
        $room->updateStatus();

        // Terminate contract
        $contract->update([
            'status'               => 'Terminated',
            'termination_reason'   => $request->reason,
            'terminated_at'        => now(),
        ]);

        // Notify student
        Notification::create([
            'user_id' => $userId,
            'title'   => 'Contract Terminated',
            'message' => 'Your contract has been terminated. Reason: ' . $request->reason,
            'type'    => 'general',
        ]);

        return back()->with('success', 'Resident removed successfully.');
    }

    public function history()
{
    $history = ResidentHistory::with('user', 'room', 'contract')
                    ->latest('moved_out_at')
                    ->get();

    return view('Employee.resident_history', compact('history'));
}

    public function update(Request $request, $userId)
{
    $request->validate([
        'name'         => 'required|string|max:255',
        'email'        => 'required|email',
        'phone'        => 'required|string',
        'contract_end' => 'required|date',
    ]);

    // Update user details
    $user = \App\Models\User::findOrFail($userId);
    $user->update([
        'name'  => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
    ]);

    // Update contract end date
    Contract::where('user_id', $userId)
        ->where('status', 'Active')
        ->update(['contract_end' => $request->contract_end]);

    return back()->with('success', 'Resident updated successfully.');
}
}