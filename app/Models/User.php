<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'phone', 'email', 'gender',
        'password', 'role', 'position'
    ];

    protected $hidden = ['password', 'remember_token'];

    // Student relationships
    public function contracts() {
        return $this->hasMany(Contract::class);
    }

    public function activeContract() {
        return $this->hasOne(Contract::class)
                    ->where('status', 'Active');
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function concerns() {
        return $this->hasMany(Concern::class);
    }

    public function requests() {
        return $this->hasMany(RoomRequest::class);
    }

    public function notifications() {
        return $this->hasMany(Notification::class);
    }

    public function residentHistory() {
        return $this->hasMany(ResidentHistory::class);
    }

    // Landlord relationships
    public function dormitories() {
        return $this->hasMany(Dormitory::class, 'landlord_id');
    }

    public function events() {
        return $this->hasMany(Event::class, 'landlord_id');
    }

    // Role checks
    public function isLandlord() {
        return $this->role === 'landlord';
    }

    public function isStudent() {
        return $this->role === 'student';
    }
}