<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Concern;
use App\Models\ConcernMessage;
use App\Models\Notification;
use Illuminate\Http\Request;

class LandlordConcernController extends Controller
{
    public function index()
    {
        $concerns = Concern::with('user', 'messages')
                        ->latest()
                        ->get();

        return view('Employee.concern_employee', compact('concerns'));
    }

    public function reply(Request $request, Concern $concern)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        ConcernMessage::create([
            'concern_id' => $concern->id,
            'sender'     => 'landlord',
            'message'    => $request->message,
        ]);

        // Auto acknowledge if still pending
        if ($concern->status === 'Pending') {
            $concern->update(['status' => 'Acknowledged']);
        }

        // Notify student
        Notification::create([
            'user_id' => $concern->user_id,
            'title'   => 'Concern Reply',
            'message' => 'The landlord has replied to your concern.',
            'type'    => 'concern',
        ]);

        return back()->with('success', 'Reply sent.');
    }

    public function updateStatus(Request $request, Concern $concern)
    {
        $request->validate([
            'status' => 'required|in:Pending,Acknowledged,Resolved',
        ]);

        $concern->update(['status' => $request->status]);

        // Notify student
        Notification::create([
            'user_id' => $concern->user_id,
            'title'   => 'Concern Status Updated',
            'message' => 'Your concern status has been updated to: ' . $request->status,
            'type'    => 'concern',
        ]);

        return back()->with('success', 'Status updated.');
    }
}