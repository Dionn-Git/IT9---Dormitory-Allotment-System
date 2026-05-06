<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'contract_id', 'user_id', 'amount',
        'month_covered', 'due_date', 'paid_at',
        'payment_method', 'reference_no',
        'screenshot', 'payment_status'
    ];

    public function contract() {
        return $this->belongsTo(Contract::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}