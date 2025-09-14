<?php

namespace Modules\Teams\tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Booking\Models\Booking;
use Modules\TeamAvailability\Models\TeamAvailability;
use Modules\Teams\Models\Team;
use Modules\Tenants\Models\Tenant;
use Modules\Users\Models\User;
use Tests\TestCase;

class GenerateSlotsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_correctly_generates_available_slots()
    {
        // Setup: Create a tenant, a user, a team, and the team's availability
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);
        $team = Team::factory()->create(['tenant_id' => $tenant->id]);

        // The team is available on a specific day of the week (e.g., Sunday = 0)
        TeamAvailability::factory()->create([
            'team_id' => $team->id,
            'day_of_week' => 0, // Sunday
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
        ]);

        // Setup: Create an existing booking that should block a slot
        $bookedSlotStart = Carbon::parse('2025-06-01 10:00:00');
        $bookedSlotEnd = Carbon::parse('2025-06-01 11:00:00');

        Booking::factory()->create([
            'team_id' => $team->id,
            'user_id' => $user->id,
            'tenant_id' => $tenant->id,
            'start_time' => $bookedSlotStart,
            'end_time' => $bookedSlotEnd,
        ]);

        // Make the API request
        $this->actingAs($user, 'sanctum'); // Authenticate as the user
        $response = $this->getJson("/api/v1/teams/{$team->id}/generate-slots?from=2025-06-01&to=2025-06-01");

        // Assertions
        $response->assertStatus(200); // Check if the request was successful

        $response->assertJsonStructure(['slots' => [
            '*' => ['start_time', 'end_time']
        ]]); // Check the JSON structure

        // The expected available slots (Sunday from 9-12, but 10-11 is booked)
        $expectedSlots = [
            ['start_time' => '2025-06-01 09:00:00', 'end_time' => '2025-06-01 10:00:00'],
            ['start_time' => '2025-06-01 11:00:00', 'end_time' => '2025-06-01 12:00:00'],
        ];

        // Assert that the returned slots match the expected slots
        $response->assertJson(['slots' => $expectedSlots]);
    }
}
