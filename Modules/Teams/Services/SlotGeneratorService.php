<?php

namespace Modules\Teams\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;


class SlotGeneratorService
{
    public function generate(Collection $availabilities, Collection $bookings, Carbon $startDate, Carbon $endDate): array
    {
        $slots = [];
        $currentDate = $startDate->copy()->startOfDay();
        $endDate = $endDate->copy()->endOfDay();

        while ($currentDate->lte($endDate)) {
            $dayOfWeek = $currentDate->dayOfWeek;

            $availableForDay = $availabilities->firstWhere('day_of_week', $dayOfWeek);

            if ($availableForDay) {
                $startTime = Carbon::parse($currentDate->format('Y-m-d') . ' ' . $availableForDay->start_time);
                $endTime = Carbon::parse($currentDate->format('Y-m-d') . ' ' . $availableForDay->end_time);

                while ($startTime->lt($endTime)) {
                    $slotEndTime = $startTime->copy()->addHour();


                    if (!$this->isSlotBooked($bookings, $startTime, $slotEndTime)) {
                        $slots[] = [
                            'start_time' => $startTime->toDateTimeString(),
                            'end_time' => $slotEndTime->toDateTimeString(),
                        ];
                    }

                    $startTime->addHour();
                }
            }
            $currentDate->addDay();
        }

        return $slots;
    }

    private function isSlotBooked(Collection $bookings, Carbon $startTime, Carbon $endTime): bool
    {
        return $bookings->where(function ($booking) use ($startTime, $endTime) {
            return ($booking->start_time >= $startTime && $booking->start_time < $endTime)
                || ($booking->end_time > $startTime && $booking->end_time <= $endTime)
                || ($booking->start_time < $startTime && $booking->end_time > $endTime);
        })->isNotEmpty();
    }
}
