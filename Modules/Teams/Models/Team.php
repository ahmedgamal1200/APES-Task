<?php

namespace Modules\Teams\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Booking\Models\Booking;
use Modules\TeamAvailability\Models\TeamAvailability;
use Modules\Tenants\Models\Tenant;


class Team extends Model
{
    protected $fillable = ['name', 'tenant_id'];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function availability()
    {
        return $this->hasMany(TeamAvailability::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
