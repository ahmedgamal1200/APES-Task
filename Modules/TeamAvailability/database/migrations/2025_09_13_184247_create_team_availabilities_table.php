<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Teams\Models\Team;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('team_availabilities', function (Blueprint $table) {
            $table->id();
            $table->integer('day_of_week'); // 0 (Sunday) to 6 (Saturday)
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->foreignIdFor(Team::class)
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
        Schema::dropIfExists('team_availabilities');
    }
};
