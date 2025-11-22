<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class ScheduleException extends Model
{
    protected $table = 'schedule_exceptions';

    use SoftDeletes;

    protected $fillable = [
        'court_id',
        'type',
        'date',
        'start_time',
        'end_time',
        'price_per_hour',
    ];

    protected $casts = [
        'exception_date' => 'date',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'price_per_hour' => 'decimal:2',
    ];

    /**
     * Relationships
     */
    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    /**
     * Determine if the exception applies to the whole day.
     */
    public function isWholeDay(): bool
    {
        return is_null($this->start_time) && is_null($this->end_time);
    }

    /**
     * Check if exception covers a specific time period.
     */
    public function matchesTimeRange($start, $end): bool
    {
        if ($this->isWholeDay()) {
            return true;
        }

        return (
            $start->format('H:i:s') >= $this->start_time &&
            $end->format('H:i:s')   <= $this->end_time
        );
    }
}
