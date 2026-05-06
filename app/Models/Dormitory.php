<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Dormitory extends Model
{
     protected $table = 'dormitory';
    protected $fillable = [
        'landlord_id', 'name', 'address',
        'contact_number', 'email',
        'open_time', 'close_time',
        'operating_days', 'description'
    ];

    public function landlord() {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    public function rooms() {
        return $this->hasMany(Room::class);
    }
}