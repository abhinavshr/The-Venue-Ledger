<?php

namespace App\Http\Controllers\Api\Booking;

use App\Services\BookingService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends Controller
{
    public function store(StoreBookingRequest $request, BookingService $bookingService)
    {
        $validatedBookingData = $request->validated();
        $validatedBookingData['user_id'] = auth()->id();

        $booking = $bookingService->createBooking($validatedBookingData);

        return $this->responseSuccess(
            $booking,
            'Booking created successfully.',
            Response::HTTP_CREATED
        );
    }
}
