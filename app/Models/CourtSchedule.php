<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\FutsalVenueScope;

class CourtSchedule extends Model
{
    protected $table = 'court_schedules';

    protected $fillable = [
        'futsal_venue_id',
        'court_id',
        'start_time',
        'end_time',
        'max_slots',
        'recurring_days',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new FutsalVenueScope());
    }

    // Accessor & Mutator for recurring_days
    public function getRecurringDaysAttribute($value)
    {
        return explode(',', $value);
    }

    public function setRecurringDaysAttribute($value)
    {
        $this->attributes['recurring_days'] = is_array($value)
            ? implode(',', $value)
            : $value;
    }

    // Relationships
    public function futsalVenue()
    {
        return $this->belongsTo(FutsalVenue::class);
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }
}