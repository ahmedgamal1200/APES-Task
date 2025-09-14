<?php

namespace Modules\TeamAvailability\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamAvailabilityRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'day_of_week' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',
            'team_id' => 'required|exists:teams,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
