<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Concern;
use App\Models\ConcernMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConcernController extends Controller
{
    public function index()
    {
        $concerns = Concern::where('user_id', Auth::id())
                        ->with('messages')
                        ->latest()
                        ->get();

        return view('Student.concern_student', compact('concerns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'        => 'required|string',
            'description' => 'required|string',
        ]);

        $concern = Concern::create([
            'user_id'     => Auth::id(),
            'type'        => $request->type,
            'description' => $request->description,
            'status'      => 'Pending',
        ]);

        // Add first message
        ConcernMessage::create([
            'concern_id' => $concern->id,
            'sender'     => 'student',
            'message'    => $request->description,
        ]);

        return back()->with('success', 'Concern submitted successfully.');
    }
}