<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ResidentHistory extends Model
{
    protected $table = 'resident_history';

    protected $fillable = [
        'user_id', 'room_id', 'contract_id',
        'contract_start', 'contract_end',
        'monthly_rate', 'end_reason',
        'remarks', 'moved_out_at'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function room() {
        return $this->belongsTo(Room::class);
    }

    public function contract() {
        return $this->belongsTo(Contract::class);
    }
}