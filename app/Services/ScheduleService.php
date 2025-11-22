<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\{Booking, RecurringSchedule, ScheduleException};

class ScheduleService
{
    /**
     * Validate if the schedule is available
     * Rule A: Only 1 booking per court per time range
     */
    public function validateSchedule(int $courtId, string $startTime, string $endTime)
    {
        $start = Carbon::parse($startTime);
        $end   = Carbon::parse($endTime);
        $day   = $start->format('D');
        $date  = $start->toDateString();

        // Check for any schedule exception on this date
        $exception = ScheduleException::where('court_id', $courtId)
        ->whereDate('date', $date)
        // ->lockForUpdate()
        ->first();

        if ($exception) {
            // Whole day closed
            if ($exception->type === 'Closed' && $exception->isWholeDay()) {
                throw new Exception("Court is closed on {$date}.");
            }

            // Partial-time closed (time must overlap)
            if ($exception->type === 'Closed' && $exception->matchesTimeRange($start, $end)) {
                throw new Exception("Court is closed from {$exception->start_time} to {$exception->end_time}.");
            }
        }

        // Find recurring schedule for the day
        $schedule = RecurringSchedule::where('court_id', $courtId)
            ->where('day_of_week', $day)
            ->where('start_time', '<=', $start->format('H:i:s'))
            ->where('end_time', '>=', $end->format('H:i:s'))
            // ->lockForUpdate()
            ->first();

        if (!$schedule) {
            throw new ModelNotFoundException("No available schedule for {$day} at this time.");
        }

        // Check for overlapping bookings
        $conflict = Booking::where('court_id', $courtId)
            ->whereDate('start_time', $start->toDateString())
            ->where(function ($q) use ($start, $end) {
                $q->where('start_time', '<', $end)
                  ->where('end_time', '>', $start);
            })
            ->lockForUpdate() // lock matching rows to prevent race conditions
            ->exists();

        if ($conflict) {
            throw new Exception("This time range is already booked.");
        }

        return true;
    }

    /**
     * Optional helper to check if day is weekend dynamically
     */
    // public function isWeekend(int $courtId, string $day): bool
    // {
    //     return WeekendSetting::where('court_id', $courtId)
    //         ->where('day', $day)
    //         ->exists();
    // }
}
