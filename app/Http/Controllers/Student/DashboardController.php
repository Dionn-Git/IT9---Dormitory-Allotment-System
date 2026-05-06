<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Dormitory;
use App\Models\Contract;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get active contract with room
        $contract = Contract::where('user_id', $user->id)
                        ->where('status', 'Active')
                        ->with('room', 'payments')
                        ->first();

        // Get recent notifications paginated by 3
        $notifications = Notification::where('user_id', $user->id)
                            ->latest()
                            ->paginate(3);

        // Get unread count
        $unreadCount = Notification::where('user_id', $user->id)
                            ->where('is_read', false)
                            ->count();

        // Get dormitory details
        $dormitory = Dormitory::first();

        return view('Student.dashboard', compact(
            'user',
            'contract',
            'notifications',
            'unreadCount',
            'dormitory'
        ));
    }
}