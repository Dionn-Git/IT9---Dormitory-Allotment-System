<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Http\Request;

class LandlordPaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('user', 'contract.room')
                        ->latest()
                        ->get();

        return view('Employee.payments_employee', compact('payments'));
    }

    public function approve(Payment $payment)
    {
        $payment->update([
            'payment_status' => 'Paid',
            'paid_at'        => now()->format('Y-m-d'),
        ]);

        // Notify student
        Notification::create([
            'user_id' => $payment->user_id,
            'title'   => 'Payment Approved',
            'message' => 'Your payment of ₱' . number_format($payment->amount, 2) . ' for ' . $payment->month_covered . ' has been approved.',
            'type'    => 'payment',
        ]);

        return back()->with('success', 'Payment approved successfully.');
    }
}