<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CourtSchedule;

class CourtSchedulePolicy
{
    /**
     * Helper to check if user belongs to the same futsalVenue.
     */
    protected function belongsToFutsalVenue(User $user, CourtSchedule $schedule): bool
    {
        return $user->futsalVenue && $user->futsalVenue->id === $schedule->futsal_venue_id;
    }
    

    /**
     * Determine whether the user can view any schedules.
     */
    public function viewAny(User $user): bool
    {
        return $user->futsalVenue !== null;
    }

    /**
     * Determine whether the user can view the schedule.
     */
    public function view(User $user, CourtSchedule $schedule): bool
    {
        return $this->belongsToFutsalVenue($user, $schedule);
    }

    /**
     * Determine whether the user can create schedules.
     */
    public function create(User $user): bool
    {
        return $user->futsalVenue !== null;
    }

    /**
     * Determine whether the user can update the schedule.
     */
    public function update(User $user, CourtSchedule $schedule): bool
    {
        return $this->belongsToFutsalVenue($user, $schedule);
    }

    /**
     * Determine whether the user can delete the schedule.
     */
    public function delete(User $user, CourtSchedule $schedule): bool
    {
        return $this->belongsToFutsalVenue($user, $schedule);
    }
}