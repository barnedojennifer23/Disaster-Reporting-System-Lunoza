<?php

namespace App\Http\Controllers;

use App\Models\BarangayIncident;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BarangayBantayController extends Controller
{
    private function positions(): array
    {
        return ['Barangay Captain', 'Kagawad', 'Tanod', 'Resident', 'SK Chairperson'];
    }

    private function categories(): array
    {
        return ['Flood', 'Landslide', 'Fire', 'Earthquake', 'Storm', 'Tornado'];
    }

    private function barangays(): array
    {
        return ['Poblacion', 'Kalasungay', 'Casisang', 'Sumpong', 'Imbatug', 'Can-ayan', 'Lumbia', 'Malaybalay', 'San Martin', 'San Francisco', 'San Jose', 'San Juan', 'San Lorenzo', 'San Nicolas', 'San Pedro'];
    }

    private function responseTeams(): array
    {
        return ['BDRRMO', 'BFP', 'PNP', 'RHU', 'Barangay', 'None'];
    }

    private function statuses(): array
    {
        return ['Reported', 'Assessing', 'Responding', 'Resolved', 'Closed'];
    }

    public function create()
    {
        return view('barangaybantay.create', [
            'positions' => $this->positions(),
            'categories' => $this->categories(),
            'barangays' => $this->barangays(),
            'responseTeams' => $this->responseTeams(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'incident_reporter' => ['required', 'string', 'max:100'],
            'reporter_position' => ['required', Rule::in($this->positions())],
            'contact_number' => ['required', 'string', 'max:15'],
            'disaster_category' => ['required', Rule::in($this->categories())],
            'specific_barangay' => ['required', Rule::in($this->barangays())],
            'affected_families' => ['required', 'integer', 'min:0'],
            'affected_individuals' => ['required', 'integer', 'min:0'],
            'evacuation_center' => ['nullable', 'string'],
            'response_team_assigned' => ['required', Rule::in($this->responseTeams())],
            'description' => ['required', 'string', 'min:10'],
            'status' => ['required', Rule::in($this->statuses())],
        ]);

        BarangayIncident::create($data);

        return redirect()->route('incidents.create')->with('success', 'Incident reported successfully!');
    }

    public function index()
    {
        $incidents = BarangayIncident::orderBy('reported_at', 'desc')->get();

        return view('barangaybantay.index', [
            'incidents' => $incidents,
            'totalActiveIncidents' => $incidents->where('status', '!=', 'Closed')->count(),
            'totalAffectedFamilies' => $incidents->sum('affected_families'),
            'totalAffectedIndividuals' => $incidents->sum('affected_individuals'),
            'responseTeams' => $this->responseTeams(),
            'statuses' => $this->statuses(),
        ]);
    }

    public function show($id)
    {
        $incident = BarangayIncident::findOrFail($id);

        return view('barangaybantay.show', [
            'incident' => $incident,
            'responseTeams' => $this->responseTeams(),
            'statuses' => $this->statuses(),
        ]);
    }

    public function assignTeam(Request $request, $id)
    {
        $incident = BarangayIncident::findOrFail($id);

        $data = $request->validate([
            'response_team_assigned' => ['required', Rule::in($this->responseTeams())],
        ]);

        $incident->update(['response_team_assigned' => $data['response_team_assigned']]);

        return redirect()->back()->with('success', 'Response team assigned successfully!');
    }

    public function updateStatus($id, $status)
    {
        if (!in_array($status, $this->statuses(), true)) {
            return redirect()->back()->with('error', 'Invalid status selected.');
        }

        $incident = BarangayIncident::findOrFail($id);
        $incident->update(['status' => $status]);

        return redirect()->back()->with('success', "Status updated to {$status}!");
    }

    public function destroy($id)
    {
        $incident = BarangayIncident::findOrFail($id);
        $incident->delete();

        return redirect()->route('incidents.index')->with('success', 'Incident deleted successfully!');
    }
}
