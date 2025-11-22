<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecurringSchedule extends Model
{
    protected $table = 'recurring_schedules';

    protected $fillable = [
        'court_id',
        'day_of_week',
        'start_time',
        'end_time',
        'max_slots',
        'rate_multiplier',
    ];
}
