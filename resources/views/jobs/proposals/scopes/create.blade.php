@extends('layouts.admin')

@section('page-title', 'Add Scope')

@section('page-breadcrumbs')
	<ol class="breadcrumb my-2">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Admin Home</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Jobs</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.show', $proposal->job->id) }}">{{ $proposal->job->number }}</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.proposals.show', [$proposal->job->id, $proposal->id]) }}">Proposal</a></li>
		<li class="breadcrumb-item active">New Scope</li>
	</ol>
@endsection

@section('page-content')
	<p class="lead">
		Enter each new scope description on a new line.
	</p>
	<form 	action="{{ route('jobs.proposals.scopes.store', [$proposal->job->id, $proposal->id]) }}"
			method="POST"
			enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="form-group">
			<label 	for="scopeDescription" 
					{{ $errors->has('description') ? 'text-danger' :'' }}>
				Description
			</label>
			<textarea	name="description"
						class="form-control {{ $errors->has('description') ? 'is-invalid' :'' }}"
						id="scopeDescription"
						autocomplete="off"
						rows="5"
						min="10"
						required>{{ old('description') }}</textarea>
			<small class="form-text {{ $errors->has('description') ? 'invalid-feedback' :'' }}">
				Required. At least 10 characters.
			</small>
		</div>

		<button class="btn btn-primary" type="submit">Save New</button>
		<a class="btn btn-outline-primary" href="{{ route('jobs.proposals.show', [$proposal->job->id, $proposal->id]) }}#scope">
			Cancel
		</a>
	</form>
@stop