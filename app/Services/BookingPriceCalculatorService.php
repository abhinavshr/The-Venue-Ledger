<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Models\{CourtPriceShift, ScheduleException};

class BookingPriceCalculatorService
{
    /**
     * Calculate booking price based on shifts/exceptions
     */
    public function calculatePrice(int $courtId, string $startTime, string $endTime)
    {
        $start = Carbon::parse($startTime);
        $end   = Carbon::parse($endTime);
        $day   = $start->format('D');
        $date  = $start->toDateString();

        // Check for special-rate exception
        $exception = ScheduleException::where('court_id', $courtId)
            ->where('type', 'SpecialRate')
            ->whereDate('exception_date', $date)
            ->first();

        if ($exception) {
            // Whole-day → always applies
            if ($exception->isWholeDay()) {
                return $this->calculateSpecialPrice($exception, $start, $end);
            }

            // Partial-time → applies only if within range
            if ($exception->matchesTimeRange($start, $end)) {
                return $this->calculateSpecialPrice($exception, $start, $end);
            }
        }

        // Match shift
        $shift = $this->matchShift($courtId, $day, $start, $end);

        if (!$shift) {
            throw new Exception("No price shift matches this time.");
        }

        return $this->calculateShiftPrice($shift, $start, $end);
    }

    /**
     * Multi-layered shift matching logic
     */
    private function matchShift(int $courtId, string $day, Carbon $start, Carbon $end)
    {
        $startTime = $start->format('H:i:s');
        $endTime   = $end->format('H:i:s');

        // Dynamic weekend detection
        // $isWeekend = app(ScheduleService::class)->isWeekend($courtId, $day);

        $isWeekend = in_array($day, ['Sat', 'Sun']);
        $group     = $isWeekend ? 'Weekend' : 'Weekday';

        return
            $this->findShift($courtId, $day, $startTime, $endTime) ??
            $this->findShift($courtId, $group, $startTime, $endTime) ??
            $this->findShift($courtId, 'Daily', $startTime, $endTime);
    }

    /**
     * Find matching shift
     */
    private function findShift(int $courtId, string $label, string $start, string $end)
    {
        return CourtPriceShift::where('court_id', $courtId)
            ->where('day', $label)
            ->get()
            ->first(fn($shift) => $start >= $shift->start_time && $end <= $shift->end_time);
    }

    /**
     * Standard shift-based price calculation
     */
    private function calculateShiftPrice($shift, Carbon $start, Carbon $end)
    {
        $hours = $end->floatDiffInMinutes($start, true) / 60;

        $pricePerHour = max(0, $shift->price_per_hour);
        $totalPrice   = round($hours * $pricePerHour, 2);

        return [
            'price_per_hour' => $pricePerHour,
            'total_price'    => $totalPrice,
            'shift'          => $shift,
        ];
    }

    /**
     * Special-Day price calculator
     */
    private function calculateSpecialPrice($exception, Carbon $start, Carbon $end)
    {
        $hours = $end->floatDiffInMinutes($start, true) / 60;
        $pricePerHour = max(0, $exception->price_per_hour);

        return [
            'price_per_hour' => $pricePerHour,
            'total_price'    => round($hours * $pricePerHour, 2),
            'shift'          => $exception,
            'type'           => 'SpecialRate',
        ];
    }
}
