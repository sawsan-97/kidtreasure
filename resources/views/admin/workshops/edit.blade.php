@extends('admin.layouts.app')

@section('title', 'Edit Workshop')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Workshop</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.workshops.index') }}">Workshops</a></li>
        <li class="breadcrumb-item active">Edit: {{ $workshop->name_en }}</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Workshop Information
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.workshops.update', $workshop) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name_en" class="form-label">English Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name_en') is-invalid @enderror" id="name_en" name="name_en" value="{{ old('name_en', $workshop->name_en) }}" required>
                            @error('name_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name_ar" class="form-label">Arabic Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name_ar') is-invalid @enderror" id="name_ar" name="name_ar" value="{{ old('name_ar', $workshop->name_ar) }}" dir="rtl" required>
                            @error('name_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="target_age_group" class="form-label">Target Age Group <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('target_age_group') is-invalid @enderror" id="target_age_group" name="target_age_group" value="{{ old('target_age_group', $workshop->target_age_group) }}" placeholder="e.g. 5-8 years" required>
                            @error('target_age_group')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active">
                                <option value="1" {{ old('is_active', $workshop->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $workshop->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="description_en" class="form-label">English Description <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description_en') is-invalid @enderror" id="description_en" name="description_en" rows="4" required>{{ old('description_en', $workshop->description_en) }}</textarea>
                    @error('description_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="description_ar" class="form-label">Arabic Description <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description_ar') is-invalid @enderror" id="description_ar" name="description_ar" rows="4" dir="rtl" required>{{ old('description_ar', $workshop->description_ar) }}</textarea>
                    @error('description_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.workshops.show', $workshop) }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Workshop</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-calendar me-1"></i>
            Workshop Events
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Manage Events</h5>
                <a href="#" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Add New Event
                </a>
            </div>

            @if($workshop->events->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Location</th>
                                <th>Price (JOD)</th>
                                <th>Attendees</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($workshop->events as $event)
                                <tr>
                                    <td>{{ $event->event_date->format('Y-m-d') }}</td>
                                    <td>{{ $event->event_time->format('H:i') }}</td>
                                    <td>{{ $event->location }}</td>
                                    <td>{{ number_format($event->price_jod, 2) }}</td>
                                    <td>
                                        {{ $event->current_attendees }} / {{ $event->max_attendees }}
                                    </td>
                                    <td>
                                        @if($event->is_open_for_registration)
                                            <span class="badge bg-success">Open</span>
                                        @else
                                            <span class="badge bg-danger">Closed</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="#" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    No events have been scheduled for this workshop yet.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add any JavaScript for form validation or enhancement here
    document.addEventListener('DOMContentLoaded', function() {
        // Example: Add character counter for description fields
        const descriptionEn = document.getElementById('description_en');
        const descriptionAr = document.getElementById('description_ar');
        
        // You could add rich text editor initialization here if needed
        // For example: CKEDITOR.replace('description_en');
    });
</script>
@endsection
