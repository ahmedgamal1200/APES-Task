<?php

namespace Modules\Booking\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Modules\Booking\Exceptions\BookingConflictException;
use Modules\Booking\Http\Requests\StoreBookingRequest;
use Modules\Booking\Models\Booking;
use Modules\Bookings\Services\BookingService;
use Exception;

class BookingController extends Controller
{
    public function __construct(protected BookingService $bookingService)
    {
       //
    }
    public function index(): JsonResponse
    {
        $bookings = Booking::query()->where('tenant_id', auth()->user()->tenant_id)
            ->where('user_id', auth()->id())
            ->get();

        return response()->json(['bookings' => $bookings]);
    }


    public function store(StoreBookingRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $validatedData['start_time'] = Carbon::parse($validatedData['start_time']);
            $validatedData['end_time'] = Carbon::parse($validatedData['end_time']);

            $booking = $this->bookingService->createBooking($validatedData, auth()->user());

            return response()->json(['message' => 'Booking created successfully!', 'booking' => $booking], 201);

        } catch (BookingConflictException $e) {
            return response()->json(['message' => $e->getMessage()], 409); // 409 Conflict
        } catch (Exception $e) {
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }


    public function destroy(Booking $booking): JsonResponse
    {
        if ($booking->user_id !== auth()->id() || $booking->tenant_id !== auth()->user()->tenant_id) {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking cancelled successfully.']);
    }
}
