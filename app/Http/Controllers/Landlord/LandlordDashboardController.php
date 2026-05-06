<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Room;
use App\Models\Concern;
use App\Models\RoomRequest;
use App\Models\Payment;
use App\Models\Event;

class LandlordDashboardController extends Controller
{
    public function index()
    {
    $totalResidents = Contract::where('status', 'Active')->count();
    $availableRooms = Room::where('status', 'Available')->count();
    $pendingConcerns = Concern::where('status', 'Pending')->count();
    $pendingRequests = RoomRequest::where('status', 'Pending')->count();

    $recentPayments = Payment::with('user', 'contract.room')
                        ->latest()
                        ->take(10)
                        ->get();

    // Payments for calendar
    $calendarPayments = Payment::with('user', 'contract.room')
                        ->get()
                        ->map(function($payment) {
                            return [
                                'id'          => $payment->id,
                                'name'        => $payment->user->name,
                                'room'        => $payment->contract->room->name ?? '—',
                                'amount'      => $payment->amount,
                                'due_date'    => $payment->due_date,
                                'paid_at'     => $payment->paid_at,
                                'status'      => $payment->payment_status,
                                'month'       => \Carbon\Carbon::parse($payment->due_date)->month - 1,
                                'day'         => \Carbon\Carbon::parse($payment->due_date)->day,
                                'year'        => \Carbon\Carbon::parse($payment->due_date)->year,
                            ];
                        });

    $events = Event::where('landlord_id', auth()->id())
                ->orderBy('event_date')
                ->get();

    return view('Employee.employee_dashboard', compact(
        'totalResidents',
        'availableRooms',
        'pendingConcerns',
        'pendingRequests',
        'recentPayments',
        'calendarPayments',
        'events'
    ));
    }
}