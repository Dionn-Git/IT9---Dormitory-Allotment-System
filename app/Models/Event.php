<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'landlord_id', 'title', 'type',
        'event_date', 'description'
    ];

    public function landlord() {
        return $this->belongsTo(User::class, 'landlord_id');
    }
}