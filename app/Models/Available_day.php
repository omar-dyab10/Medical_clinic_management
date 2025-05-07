<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Available_day extends Model
{
    protected $fillable = [
        'doctor_id',
        'available_date',
        'start_time',
        'end_time',
    ];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function time_slots()
    {
        return $this->hasMany(Time_slot::class);
    }

}
