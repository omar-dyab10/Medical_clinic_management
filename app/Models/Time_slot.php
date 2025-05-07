<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Time_slot extends Model
{
    protected $fillable = [
        'available_day_id',
        'start_time',
        'end_time',
        'status',
    ];
    public function available_day()
    {
        return $this->belongsTo(Available_day::class);
    }
    public function booking()
    {
        return $this->hasOne(Booking::class);
    }
}
