@extends('layouts.barangaybantay')

@section('title', 'Incident Dashboard')

@section('content')
    <div class="page-header">
        <h1>Incident Dashboard</h1>
        <p>Monitor recent barangay incidents, response teams, and impact totals at a glance.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success py-3" role="alert">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger py-3" role="alert">{{ session('error') }}</div>
    @endif

    <div class="row row-cols-1 row-cols-md-3 g-3 mb-4">
        <div class="col">
            <div class="status-card">
                <div class="status-title">Active Incidents</div>
                <div class="status-value">{{ $totalActiveIncidents }}</div>
            </div>
        </div>
        <div class="col">
            <div class="status-card">
                <div class="status-title">Affected Families</div>
                <div class="status-value">{{ $totalAffectedFamilies }}</div>
            </div>
        </div>
        <div class="col">
            <div class="status-card">
                <div class="status-title">Affected Individuals</div>
                <div class="status-value">{{ $totalAffectedIndividuals }}</div>
            </div>
        </div>
    </div>

    <div class="card p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Disaster Category</th>
                        <th>Barangay</th>
                        <th>Reporter</th>
                        <th>Affected Families</th>
                        <th>Response Team</th>
                        <th>Status</th>
                        <th>Reported Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($incidents as $incident)
                        <tr>
                            <td>{{ $incident->disaster_category }}</td>
                            <td>{{ $incident->specific_barangay }}</td>
                            <td>{{ $incident->incident_reporter }}</td>
                            <td>{{ $incident->affected_families }}</td>
                            <td>{{ $incident->response_team_assigned }}</td>
                            <td>
                                @php
                                    $statusColor = 'secondary';
                                    if ($incident->status === 'Reported') { $statusColor = 'danger'; }
                                    if ($incident->status === 'Assessing') { $statusColor = 'warning'; }
                                    if ($incident->status === 'Responding') { $statusColor = 'warning'; }
                                    if ($incident->status === 'Resolved') { $statusColor = 'success'; }
                                    if ($incident->status === 'Closed') { $statusColor = 'secondary'; }
                                @endphp
                                <span class="badge badge-status bg-{{ $statusColor }} text-white">{{ $incident->status }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($incident->reported_at)->format('M d, Y') }}</td>
                            <td>
                                <div class="d-flex flex-column gap-2">
                                    <a href="{{ route('incidents.show', $incident->id) }}" class="btn btn-primary btn-sm">View Details</a>
                                    <form action="{{ route('incidents.assignTeam', $incident->id) }}" method="POST" class="d-flex gap-2 flex-wrap">
                                        @csrf
                                        @method('PUT')
                                        <select name="response_team_assigned" class="form-select form-select-sm" required>
                                            <option value="">Assign Team</option>
                                            @foreach($responseTeams as $team)
                                                <option value="{{ $team }}" {{ $incident->response_team_assigned === $team ? 'selected' : '' }}>{{ $team }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-secondary btn-sm">Assign Team</button>
                                    </form>
                                    <form action="/incidents/{{ $incident->id }}/" method="POST" class="d-flex gap-2 flex-wrap" onsubmit="return updateStatusAction(this);" data-base="/incidents/{{ $incident->id }}/">
                                        @csrf
                                        @method('PUT')
                                        <select name="new_status" class="form-select form-select-sm" required>
                                            <option value="">Update Status</option>
                                            @foreach($statuses as $status)
                                                @if($status !== $incident->status)
                                                    <option value="{{ $status }}">{{ $status }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-warning btn-sm">Update</button>
                                    </form>
                                    <form action="{{ route('incidents.destroy', $incident->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this incident?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No incidents reported yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function updateStatusAction(form) {
            var select = form.querySelector('select[name="new_status"]');
            if (!select.value) {
                return false;
            }
            var base = form.dataset.base || form.action;
            form.action = base + select.value;
            return true;
        }
    </script>
@endpush
