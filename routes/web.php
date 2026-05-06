<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\RoomController;
use App\Http\Controllers\Student\PaymentController;
use App\Http\Controllers\Student\ConcernController;
use App\Http\Controllers\Landlord\LandlordDashboardController;
use App\Http\Controllers\Landlord\LandlordRoomController;
use App\Http\Controllers\Landlord\LandlordResidentController;
use App\Http\Controllers\Landlord\LandlordPaymentController;
use App\Http\Controllers\Landlord\LandlordConcernController;
use App\Http\Controllers\Student\NotificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// ==================
// STUDENT ROUTES
// ==================
Route::middleware(['auth', 'verified', 'role:student'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms');
    Route::post('/rooms/request', [RoomController::class, 'requestRoom'])->name('rooms.request');
    Route::get('/payment', [PaymentController::class, 'index'])->name('payment');
    Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/concerns', [ConcernController::class, 'index'])->name('concerns');
    Route::post('/concerns', [ConcernController::class, 'store'])->name('concerns.store');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
});

// ==================
// PROFILE ROUTES
// ==================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.partials.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.partials.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.partials.destroy');
});

// ==================
// LANDLORD ROUTES
// ==================
Route::middleware(['auth', 'role:landlord'])->prefix('employee')->group(function () {

    // Dashboard
    Route::get('/dashboard', [LandlordDashboardController::class, 'index'])->name('employee.dashboard');

    // Rooms
    Route::get('/rooms', [LandlordRoomController::class, 'index'])->name('employee.rooms');
    Route::post('/rooms', [LandlordRoomController::class, 'store'])->name('employee.rooms.store');
    Route::put('/rooms/{room}', [LandlordRoomController::class, 'update'])->name('employee.rooms.update');
    Route::delete('/rooms/{room}', [LandlordRoomController::class, 'destroy'])->name('employee.rooms.destroy');

    // Residents
    Route::get('/residents', [LandlordResidentController::class, 'index'])->name('employee.residents');
    Route::post('/residents/{user}/early-removal', [LandlordResidentController::class, 'earlyRemoval'])->name('employee.residents.early-removal');
    Route::get('/residents/history', [LandlordResidentController::class, 'history'])->name('employee.history');
    Route::put('/residents/{user}/update', [LandlordResidentController::class, 'update'])->name('employee.residents.update');
    
    // Requests
    Route::get('/requests', [LandlordResidentController::class, 'requests'])->name('employee.requests');
    Route::post('/requests/{roomRequest}/approve', [LandlordResidentController::class, 'approveRequest'])->name('employee.requests.approve');
    Route::post('/requests/{roomRequest}/reject', [LandlordResidentController::class, 'rejectRequest'])->name('employee.requests.reject');

    // Payments
    Route::get('/payments', [LandlordPaymentController::class, 'index'])->name('employee.payments');
    Route::post('/payments/{payment}/approve', [LandlordPaymentController::class, 'approve'])->name('employee.payments.approve');

    // Concerns
    Route::get('/concerns', [LandlordConcernController::class, 'index'])->name('employee.concerns');
    Route::post('/concerns/{concern}/reply', [LandlordConcernController::class, 'reply'])->name('employee.concerns.reply');
    Route::patch('/concerns/{concern}/status', [LandlordConcernController::class, 'updateStatus'])->name('employee.concerns.status');

});

// ==================
// REDIRECT AFTER LOGIN BASED ON ROLE
// ==================
Route::get('/redirect', function () {
    if (Auth::user()->role === 'landlord') {
        return redirect()->route('employee.dashboard');
    }
    return redirect()->route('dashboard');
})->middleware('auth')->name('redirect');

require __DIR__.'/auth.php';