<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RoomRequest extends Model
{
    protected $table = 'requests';

    protected $fillable = [
        'user_id', 'room_id', 'request_type',
        'status', 'reason', 'rejection_reason'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function room() {
        return $this->belongsTo(Room::class);
    }
}