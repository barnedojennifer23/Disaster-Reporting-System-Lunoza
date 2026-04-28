<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangayIncident extends Model
{
    protected $table = 'barangay_incidents';

    public $timestamps = false;

    protected $fillable = [
        'incident_reporter',
        'reporter_position',
        'contact_number',
        'disaster_category',
        'specific_barangay',
        'affected_families',
        'affected_individuals',
        'evacuation_center',
        'response_team_assigned',
        'description',
        'status',
    ];
}
