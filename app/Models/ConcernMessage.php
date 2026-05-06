<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ConcernMessage extends Model
{
    protected $fillable = [
        'concern_id', 'sender', 'message'
    ];

    public function concern() {
        return $this->belongsTo(Concern::class);
    }
}