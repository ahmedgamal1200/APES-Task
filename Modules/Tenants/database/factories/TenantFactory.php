<?php

namespace Modules\Tenants\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tenants\Models\Tenant;
use Modules\Users\Models\User;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'user_id' => User::factory(),
        ];
    }
}
