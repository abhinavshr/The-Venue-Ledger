<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function __construct(
        protected ScheduleService $scheduleService,
        protected BookingPriceCalculatorService $priceService
    ) {}

    /**
     * Create a booking
     */
    public function createBooking(array $data)
    {
        return DB::transaction(function () use ($data) {

            // Destructure specific keys
            [
                'court_id'   => $courtId,
                'start_time' => $startTime,
                'end_time'   => $endTime,
            ] = $data;

            // Validate schedule + check for conflicts
            $this->scheduleService->validateSchedule($courtId, $startTime, $endTime);

            // Calculate price
            ['total_price' => $totalPrice] = $this->priceService->calculatePrice($courtId, $startTime, $endTime);
            $data['total_price'] = $totalPrice;

            // Create booking
            return Booking::create($data);
        });
    }
}
