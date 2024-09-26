<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        'specialization',
        "yearsOfExperience",
        "clinicalAddress",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function availableDates()
    {
        return $this->hasOne(AvailableDates::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
