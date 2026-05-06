<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'user_id', 'room_id', 'contract_start',
        'contract_end', 'monthly_rate',
        'payment_due_day', 'status',
        'termination_reason', 'terminated_at'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function room() {
        return $this->belongsTo(Room::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function residentHistory() {
        return $this->hasOne(ResidentHistory::class);
    }
}