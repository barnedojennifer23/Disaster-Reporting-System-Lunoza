<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangay_incidents', function (Blueprint $table) {
            $table->id();
            $table->string('incident_reporter', 100);
            $table->enum('reporter_position', ['Barangay Captain', 'Kagawad', 'Tanod', 'Resident', 'SK Chairperson']);
            $table->string('contact_number', 15);
            $table->enum('disaster_category', ['Flood', 'Landslide', 'Fire', 'Earthquake', 'Storm', 'Tornado']);
            $table->enum('specific_barangay', ['Poblacion', 'Kalasungay', 'Casisang', 'Sumpong', 'Imbatug', 'Can-ayan', 'Lumbia', 'Malaybalay', 'San Martin', 'San Francisco', 'San Jose', 'San Juan', 'San Lorenzo', 'San Nicolas', 'San Pedro']);
            $table->integer('affected_families')->default(0);
            $table->integer('affected_individuals')->default(0);
            $table->string('evacuation_center')->nullable();
            $table->enum('response_team_assigned', ['BDRRMO', 'BFP', 'PNP', 'RHU', 'Barangay', 'None']);
            $table->text('description');
            $table->enum('status', ['Reported', 'Assessing', 'Responding', 'Resolved', 'Closed'])->default('Reported');
            $table->timestamp('reported_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangay_incidents');
    }
};
