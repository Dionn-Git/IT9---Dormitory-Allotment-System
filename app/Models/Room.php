<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
    'dormitory_id', 'name', 'type', 'floor',
    'capacity', 'current_occupants',
    'price', 'status', 'description', 'image',
    'inclusions' // add this
    ];

    protected $casts = [
        'inclusions' => 'array' 
    ];

    public function dormitory() {
        return $this->belongsTo(Dormitory::class);
    }

    public function contracts() {
        return $this->hasMany(Contract::class);
    }

    public function activeContracts() {
        return $this->hasMany(Contract::class)
                    ->where('status', 'Active');
    }

    public function requests() {
        return $this->hasMany(RoomRequest::class);
    }

    public function residentHistory() {
        return $this->hasMany(ResidentHistory::class);
    }

    // Check if room has available space
    public function hasAvailableSpace() {
        return $this->current_occupants < $this->capacity;
    }

    // Update room status based on occupancy
    public function updateStatus() {
        if ($this->current_occupants >= $this->capacity) {
            $this->status = 'Occupied';
        } elseif ($this->current_occupants > 0) {
            $this->status = 'Available';
        } else {
            $this->status = 'Available';
        }
        $this->save();
    }
}