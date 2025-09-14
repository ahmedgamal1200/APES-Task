<?php

namespace Modules\Tenants\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Booking\Models\Booking;
use Modules\Tenants\Database\Factories\TenantFactory;
use Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Teams\Models\Team;

class Tenant extends Model
{
    protected static function newFactory(): TenantFactory
    {
        return TenantFactory::new();
    }

    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

}
