<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'plan_name',
        'duration_days',
        'start_date',
        'end_date',
        'status',
        'payment_amount',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'payment_amount' => 'decimal:2',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
