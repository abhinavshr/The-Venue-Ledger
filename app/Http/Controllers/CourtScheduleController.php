<?php

namespace App\Http\Controllers;

use App\Models\CourtSchedule;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\{StoreCourtScheduleRequest, UpdateCourtScheduleRequest};

class CourtScheduleController extends Controller
{
    /**
     * Display a listing of the court schedules.
     */
    public function index()
    {
        $schedules = CourtSchedule::latest()->get();

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
        $schedule = CourtSchedule::create($request->validated());

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
            Response::HTTP_OK
        );
    }
}
