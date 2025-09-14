<?php

use Modules\Booking\Enums\Status;
use Modules\Users\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Teams\Models\Team;
use Modules\Tenants\Models\Tenant;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->date('date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('status')->default(Status::Pending->value);

            $table->foreignIdFor(Team::class)
                    ->constrained()
                    ->cascadeOnDelete();
            $table->foreignIdFor(Tenant::class)
                    ->constrained()
                    ->cascadeOnDelete();
            $table->foreignIdFor(User::class)
                    ->constrained()
                    ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
