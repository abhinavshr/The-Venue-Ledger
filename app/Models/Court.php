<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Court extends Model
{
    use HasFactory;

    protected $fillable = [
        'futsal_venue_id',
        'name',
        'capacity',
        'surface_type',
        'price_per_hour',
        'status'
    ];

    // Relationships
    public function futsalVenue()
    {
        return $this->belongsTo(FutsalVenue::class);
    }

    public function priceShifts()
    {
        return $this->hasMany(CourtPriceShift::class);
    }

    public function recurringSchedules()
    {
        return $this->hasMany(RecurringSchedule::class);
    }
}
