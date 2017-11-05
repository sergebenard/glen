@extends('layouts.admin')

@section('page-title', 'Edit Scope')

@section('page-breadcrumbs')
	<ol class="breadcrumb my-2">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Admin Home</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Jobs</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.show', $proposal->job->id) }}">{{ $proposal->job->number }}</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.proposals.show', [$proposal->job->id, $proposal->id]) }}">Proposal</a></li>
		<li class="breadcrumb-item active">Edit Scope</li>
	</ol>
@endsection

@section('page-content')
	<p class="lead">
		All new lines will be ignored.
	</p>
	<form 	action="{{ route('jobs.proposals.scopes.update', [$proposal->job->id, $proposal->id, $scope->id]) }}"
			method="POST"
			enctype="multipart/form-data">
		{{ csrf_field() }}
		{{ method_field('PATCH') }}
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
						required>{{ old('description', $scope->description) }}</textarea>
			<small class="form-text {{ $errors->has('description') ? 'invalid-feedback' :'' }}">
				Required. At least 10 characters.
			</small>
		</div>
		<div class="form-group">
			<button class="btn btn-primary" type="submit">Update</button>
			<a class="btn btn-outline-primary" href="{{ route('jobs.proposals.show', [$proposal->job->id, $proposal->id]) }}#scope">
				Cancel
			</a>
		</div>
	</form>
	<div class="form-group">
		<form 	method="POST"
				id="deleteScope"
				action="{{ route('jobs.proposals.scopes.destroy', [ $proposal->job->id, $proposal->id, $scope->id ]) }}"
				enctype="multipart/data">
			{{ csrf_field() }}
			{{ method_field('DELETE') }}
		</form>
		<button 	data-toggle="modal"
					type="button"
					data-target="#confirmModal"
					data-titletext = "Delete Scope"
					data-formid="scope-{{ $scope->id }}"
					class="btn btn-outline-danger btn-block">
			Delete
		</button>
	</div>
@stop