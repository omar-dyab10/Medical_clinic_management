<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'time_slot_id',
        'patient_id',
        'status',
    ];
    public function time_slot()
    {
        return $this->belongsTo(Time_slot::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
