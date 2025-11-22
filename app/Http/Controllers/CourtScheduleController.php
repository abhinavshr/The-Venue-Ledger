<?php

namespace App\Http\Controllers;

use App\Models\CourtSchedule;
use App\Models\Scopes\FutsalVenueScope;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\{StoreCourtScheduleRequest, UpdateCourtScheduleRequest};

class CourtScheduleController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        // Automatically applies policy for all resource methods
        $this->authorizeResource(CourtSchedule::class, 'court_schedule');
    }

    /**
     * Display a listing of the court schedules.
     */
    public function index()
    {
        $schedules = CourtSchedule::withoutGlobalScope(FutsalVenueScope::class)
                        ->latest()
                        ->get();

        return $this->responseSuccess(
            $schedules,
            $schedules->isNotEmpty()
                ? 'Court schedules retrieved successfully.'
                : 'No Court schedules found.',
            Response::HTTP_OK
        );
    }

    /**
     * Store a newly created court schedule.
     */
    public function store(StoreCourtScheduleRequest $request)
    {
        $validatedSchedule = $request->validated();
        $validatedSchedule['futsal_venue_id'] = auth()->user()->futsalVenue->id;

        $schedule = CourtSchedule::create($validatedSchedule);

        return $this->responseSuccess(
            $schedule,
            'Court schedule created successfully.',
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified court schedule.
     */
    public function show(CourtSchedule $schedule)
    {
        return $this->responseSuccess(
            $schedule,
            'Court schedule retrieved successfully.',
            Response::HTTP_OK
        );
    }

    /**
     * Update the specified court schedule.
     *
     */
    public function update(UpdateCourtScheduleRequest $request, CourtSchedule $schedule)
    {
        $schedule->update($request->validated());

        return $this->responseSuccess(
            $schedule,
            'Court schedule updated successfully.',
            Response::HTTP_OK
        );
    }

    /**
     * Remove the specified court schedule.
     */
    public function destroy(CourtSchedule $schedule)
    {
        $schedule->delete();

        return $this->responseSuccess(
            null,
            'Court schedule deleted successfully.',
            Response::HTTP_NO_CONTENT
        );
    }
}
