@extends('layouts.admin')

@section('page-title', 'Add Labour')

@section('page-breadcrumbs')
	<ol class="breadcrumb my-2">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Admin Home</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Jobs</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.show', $job->id) }}">{{ $job->number }}</a></li>
		<li class="breadcrumb-item active">New Labour</li>
	</ol>
@endsection

@section('page-content')
	<form 	action="{{ route('jobs.labour.store', $job->id) }}"
			method="POST"
			enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="form-group">
			<label 	for="invoiceSent" 
					{{ $errors->has('count') ? 'text-danger' :'' }}>
				Hour Count
			</label>
			<input 	type="number"
					name="count"
					class="form-control {{ $errors->has('count') ? 'is-invalid' :'' }}"
					id="invoiceSent"
					value="{{ old('count', '1') }}"
					step="any"
					autocomplete="off"
					min="1"
					required>
			<small class="form-text {{ $errors->has('count') ? 'invalid-feedback' :'' }}">
				Required.
			</small>
		</div>
		<div class="form-group">
			<label 	for="labourName" 
					{{ $errors->has('description') ? 'text-danger' :'' }}>
				Labour Description
			</label>
			<input 	type="text"
					name="description"
					class="form-control {{ $errors->has('description') ? 'is-invalid' :'' }}"
					id="labourName"
					value="{{ old('description') }}"
					autocomplete="off"
					placeholder="Ex: Siding Installation" 
					required>
			<small class="form-text {{ $errors->has('description') ? 'invalid-feedback' :'' }}">
				Required.
			</small>
		</div>
		<div class="form-group">
			<label 	for="labourWage" 
					{{ $errors->has('wage') ? 'text-danger' :'' }}>
				Wage/Hour
			</label>
			<div class="input-group">
				<div class="input-group-addon {{ $errors->has('wage') ? 'bg-danger text-white' :'' }}">$</div>
				<input 	type="number"
						name="wage"
						class="form-control {{ $errors->has('wage') ? 'is-invalid' :'' }}"
						id="labourWage"
						value="{{ old('wage') }}"
						autocomplete="off"
						step="any"
						placeholder="Ex: 15.00">
			</div><!-- /input-group -->
			<small class="form-text {{ $errors->has('wage') ? 'invalid-feedback' :'' }}">
				Optional.
			</small>
		</div>

		<button class="btn btn-primary" type="submit">Save New</button>
		<a class="btn btn-outline-primary" href="{{ route('jobs.show', $job->id) }}#proposals">
			Cancel
		</a>
	</form>
@stop