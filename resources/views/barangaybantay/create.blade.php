@extends('layouts.barangaybantay')

@section('title', 'Report Incident')

@section('content')
    <div class="page-header text-center">
        <h1>Report Barangay-Level Incident</h1>
        <p>Submit a new incident report to keep response teams informed and community leaders aligned.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="card p-4">
                @if(session('success'))
                    <div class="alert alert-success py-3" role="alert">{{ session('success') }}</div>
                @endif

                <form action="{{ route('incidents.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Incident Reporter</label>
                            <input type="text" name="incident_reporter" value="{{ old('incident_reporter') }}" class="form-control" maxlength="100" required>
                            @error('incident_reporter')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Reporter Position</label>
                            <select name="reporter_position" class="form-select" required>
                                <option value="">Select position</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position }}" {{ old('reporter_position') === $position ? 'selected' : '' }}>{{ $position }}</option>
                                @endforeach
                            </select>
                            @error('reporter_position')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" value="{{ old('contact_number') }}" class="form-control" maxlength="15" required>
                            @error('contact_number')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Disaster Category</label>
                            <select name="disaster_category" class="form-select" required>
                                <option value="">Select category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ old('disaster_category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                            @error('disaster_category')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Specific Barangay</label>
                            <select name="specific_barangay" class="form-select" required>
                                <option value="">Select barangay</option>
                                @foreach($barangays as $barangay)
                                    <option value="{{ $barangay }}" {{ old('specific_barangay') === $barangay ? 'selected' : '' }}>{{ $barangay }}</option>
                                @endforeach
                            </select>
                            @error('specific_barangay')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Affected Families</label>
                            <input type="number" name="affected_families" value="{{ old('affected_families', 0) }}" class="form-control" min="0" required>
                            @error('affected_families')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Affected Individuals</label>
                            <input type="number" name="affected_individuals" value="{{ old('affected_individuals', 0) }}" class="form-control" min="0" required>
                            @error('affected_individuals')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Evacuation Center</label>
                            <input type="text" name="evacuation_center" value="{{ old('evacuation_center') }}" class="form-control">
                            @error('evacuation_center')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Response Team Assignment</label>
                            <select name="response_team_assigned" class="form-select" required>
                                <option value="">Select team</option>
                                @foreach($responseTeams as $team)
                                    <option value="{{ $team }}" {{ old('response_team_assigned') === $team ? 'selected' : '' }}>{{ $team }}</option>
                                @endforeach
                            </select>
                            @error('response_team_assigned')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="4" class="form-control" required>{{ old('description') }}</textarea>
                            @error('description')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <input type="hidden" name="status" value="Reported">
                    </div>

                    <div class="mt-4 d-flex form-actions gap-2">
                        <button type="submit" class="btn btn-primary">Report Incident</button>
                        <a href="{{ route('incidents.index') }}" class="btn btn-secondary">View All Incidents</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
