<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'specialty'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function available_days()
    {
        return $this->hasMany(Available_day::class);
    }

}
