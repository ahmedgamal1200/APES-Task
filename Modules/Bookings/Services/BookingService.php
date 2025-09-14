<?php

namespace Modules\Bookings\Services;

use Modules\Users\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Modules\Booking\Exceptions\BookingConflictException;
use Modules\Booking\Models\Booking;


class BookingService
{
    /**
     * @throws Exception
     */
    public function createBooking(array $data, User $user): Booking
    {
        // 1. التحقق من التعارض
        $isConflicting = Booking::query()->where('team_id', $data['team_id'])
            ->where(function (Builder $query) use ($data) {

                $query->where(function (Builder $query) use ($data) {
                    $query->where('start_time', '>=', $data['start_time'])
                        ->where('start_time', '<', $data['end_time']);
                })->orWhere(function (Builder $query) use ($data) {
                    $query->where('end_time', '>', $data['start_time'])
                        ->where('end_time', '<=', $data['end_time']);
                })->orWhere(function (Builder $query) use ($data) {
                    $query->where('start_time', '<', $data['start_time'])
                        ->where('end_time', '>', $data['end_time']);
                });
            })
            ->exists();

        if ($isConflicting) {
            throw new BookingConflictException('This time slot is already booked or conflicts with another booking.');
        }

        // 2. إنشاء الحجز
        return Booking::query()->create([
            'team_id' => $data['team_id'],
            'user_id' => $user->id,
            'tenant_id' => $user->tenant_id,
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
        ]);
    }
}
