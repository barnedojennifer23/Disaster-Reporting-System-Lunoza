@extends('layouts.barangaybantay')

@section('title', 'Incident Details')

@section('content')
    <div class="page-header">
        <h1>Incident Details</h1>
        <p>Review the incident summary, status, response team, and update actions for BarangayBantay.</p>
    </div>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('incidents.index') }}" class="btn btn-secondary">Back to All Incidents</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success py-3" role="alert">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger py-3" role="alert">{{ session('error') }}</div>
    @endif

    <div class="card p-4 mb-4">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="section-title">Reporter Information</div>
                <div class="mb-3">
                    <div class="field-label">Name</div>
                    <div class="field-value">{{ $incident->incident_reporter }}</div>
                </div>
                <div class="mb-3">
                    <div class="field-label">Position</div>
                    <div class="field-value">{{ $incident->reporter_position }}</div>
                </div>
                <div>
                    <div class="field-label">Contact</div>
                    <div class="field-value">{{ $incident->contact_number }}</div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="section-title">Incident Information</div>
                <div class="mb-3">
                    <div class="field-label">Category</div>
                    <div class="field-value">{{ $incident->disaster_category }}</div>
                </div>
                <div class="mb-3">
                    <div class="field-label">Barangay</div>
                    <div class="field-value">{{ $incident->specific_barangay }}</div>
                </div>
                <div>
                    <div class="field-label">Description</div>
                    <div class="field-value text-break">{{ $incident->description }}</div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="section-title">Impact Data</div>
                <div class="mb-3">
                    <div class="field-label">Affected Families</div>
                    <div class="field-value">{{ $incident->affected_families }}</div>
                </div>
                <div class="mb-3">
                    <div class="field-label">Affected Individuals</div>
                    <div class="field-value">{{ $incident->affected_individuals }}</div>
                </div>
                <div>
                    <div class="field-label">Evacuation Center</div>
                    <div class="field-value">{{ $incident->evacuation_center ?: 'N/A' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-4 mb-4">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="section-title">Response Information</div>
                <div class="mb-3">
                    <div class="field-label">Assigned Team</div>
                    <div class="field-value">{{ $incident->response_team_assigned }}</div>
                </div>
                <div class="mb-3">
                    <div class="field-label">Status</div>
                    @php
                        $statusColor = 'secondary';
                        if ($incident->status === 'Reported') { $statusColor = 'danger'; }
                        if ($incident->status === 'Assessing') { $statusColor = 'warning'; }
                        if ($incident->status === 'Responding') { $statusColor = 'warning'; }
                        if ($incident->status === 'Resolved') { $statusColor = 'success'; }
                        if ($incident->status === 'Closed') { $statusColor = 'secondary'; }
                    @endphp
                    <span class="badge badge-status bg-{{ $statusColor }} text-white">{{ $incident->status }}</span>
                </div>
                <div>
                    <div class="field-label">Reported At</div>
                    <div class="field-value">{{ \Carbon\Carbon::parse($incident->reported_at)->format('M d, Y h:i A') }}</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section-title">Update Actions</div>
                <form action="{{ route('incidents.assignTeam', $incident->id) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PUT')
                    <label class="form-label">Assign Response Team</label>
                    <div class="d-flex gap-2 flex-column flex-sm-row">
                        <select name="response_team_assigned" class="form-select" required>
                            <option value="">Select team</option>
                            @foreach($responseTeams as $team)
                                <option value="{{ $team }}" {{ $incident->response_team_assigned === $team ? 'selected' : '' }}>{{ $team }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-secondary">Assign Response Team</button>
                    </div>
                </form>

                <form action="/incidents/{{ $incident->id }}/" method="POST" id="status-update-form">
                    @csrf
                    @method('PUT')
                    <label class="form-label">Update Status</label>
                    <div class="d-flex gap-2 flex-column flex-sm-row">
                        <select name="status" class="form-select" required>
                            <option value="">Select status</option>
                            @foreach($statuses as $status)
                                @if($status !== $incident->status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endif
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-warning">Update Status</button>
                    </div>
                </form>

                <form action="{{ route('incidents.destroy', $incident->id) }}" method="POST" class="mt-3" onsubmit="return confirm('Are you sure you want to delete this incident?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Incident</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var statusForm = document.getElementById('status-update-form');
        var statusSelect = statusForm.querySelector('select[name="status"]');
        var baseAction = statusForm.action;
        statusSelect.addEventListener('change', function () {
            if (this.value) {
                statusForm.action = baseAction + this.value;
            }
        });
    </script>
@endpush
