<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $contract = $user->activeContract()->with('room')->first();
        $payments = Payment::where('user_id', $user->id)
                        ->latest()
                        ->get();

        return view('Student.payment_student', compact('payments', 'contract'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'contract_id'    => 'required|exists:contracts,id',
            'amount'         => 'required|numeric',
            'month_covered'  => 'required|string',
            'payment_method' => 'required|string',
            'reference_no'   => 'required|string',
            'screenshot'     => 'nullable|image|max:5120',
        ]);

        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')
                                ->store('screenshots', 'public');
        }

        Payment::create([
            'contract_id'    => $request->contract_id,
            'user_id'        => Auth::id(),
            'amount'         => $request->amount,
            'month_covered'  => $request->month_covered,
            'due_date'       => now()->format('Y-m-d'),
            'payment_method' => $request->payment_method,
            'reference_no'   => $request->reference_no,
            'screenshot'     => $screenshotPath,
            'payment_status' => 'Pending',
        ]);

        return back()->with('success', 'Payment submitted successfully. Waiting for approval.');
    }
}