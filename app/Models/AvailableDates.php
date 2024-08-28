<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableDates extends Model
{
    use HasFactory;

    protected $fillable = [
        "doctor_id",
        "start_date",
        "end_date",
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
