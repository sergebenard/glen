@extends('layouts.admin')

@section('page-title', 'Edit Job')

@section('page-breadcrumbs')
	<ol class="breadcrumb my-2">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Admin Home</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Jobs</a></li>
		<li class="breadcrumb-item active">Edit Job</li>
	</ol>
@endsection

@section('page-content')
	<form 	action="{{ route('jobs.update', $job->id) }}"
			method="POST"
			enctype="multipart/form-data">
		{{ csrf_field() }}
		{{ method_field( 'PATCH' ) }}
		<div class="form-group">
			<label 	for="jobName" 
					{{ $errors->has('name') ? 'text-danger' :'' }}>
				Client Name
			</label>
			<input 	type="text"
					name="name" 
					class="form-control {{ $errors->has('name') ? 'is-invalid' :'' }}"
					id="jobName"
					value="{{ old('name', $job->name) }}"
					autocomplete="off">
			<small class="form-text {{ $errors->has('name') ? 'invalid-feedback' :'' }}">
				Optional. Between 2 to 50 characters.
			</small>
		</div>

		<div class="form-group">
			<label 	for="jobEmail" 
					{{ $errors->has('email') ? 'text-danger' :'' }}>
				Email
			</label>
			<input 	type="email"
					name="email"
					class="form-control {{ $errors->has('email') ? 'is-invalid' :'' }}"
					id="jobEmail"
					value="{{ old('email', $job->email) }}"
					autocomplete="off">
			<small class="form-text {{ $errors->has('email') ? 'invalid-feedback' :'' }}">
				Optional.
			</small>
		</div>

		<div class="form-group">
			<label 	for="jobAddress" 
					{{ $errors->has('address') ? 'text-danger' :'' }}>
				Address
			</label>
			<textarea
					name="address"
					class="form-control {{ $errors->has('address') ? 'is-invalid' :'' }}"
					id="jobAddress"
					autocomplete="off"
					required>{{ old('address', $job->address) }}</textarea>
			<small class="form-text {{ $errors->has('address') ? 'invalid-feedback' :'' }}">
				Required.
			</small>
		</div>

		<div class="form-group">
			<label 	for="jobPhone" 
					{{ $errors->has('phone') ? 'text-danger' :'' }}>
				Phone
			</label>
			<input 	type="text"
					name="phone"
					class="form-control {{ $errors->has('phone') ? 'is-invalid' :'' }}"
					id="jobPhone"
					value="{{ old('phone', $job->formatPhoneNumber( $job->phone )) }}"
					autocomplete="off">
			<small class="form-text {{ $errors->has('phone') ? 'invalid-feedback' :'' }}">
				Optional. Between 10-15 characters.
			</small>
		</div>

		<div class="form-group">
			<label 	for="jobExtension" 
					{{ $errors->has('extension') ? 'text-danger' :'' }}>
				Extension
			</label>
			<input 	type="text"
					name="extension"
					class="form-control {{ $errors->has('extension') ? 'is-invalid' :'' }}"
					id="jobExtension"
					value="{{ old('extension', $job->extension) }}"
					autocomplete="off">
			<small class="form-text {{ $errors->has('extension') ? 'invalid-feedback' :'' }}">
				Optional.
			</small>
		</div>

		<div class="form-group">
			<label 	for="jobNote" 
					{{ $errors->has('note') ? 'text-danger' :'' }}>
				Note
			</label>
			<textarea
					name="note"
					class="form-control {{ $errors->has('note') ? 'is-invalid' :'' }}"
					id="jobNote"
					autocomplete="off">{{ old('note', $job->note) }}</textarea>
			<small class="form-text {{ $errors->has('note') ? 'invalid-feedback' :'' }}">
				Optional. From zero, then 2 characters to more.
			</small>
		</div>

		<button class="btn btn-primary" type="submit">Update</button>
		<a class="btn btn-outline-primary" href="{{ route('jobs.index') }}">
			Cancel
		</a>
	</form>
@stop