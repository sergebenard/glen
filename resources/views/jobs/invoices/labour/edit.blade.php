@extends('layouts.admin')

@section('page-title', 'Edit Labour')

@section('page-breadcrumbs')
	<ol class="breadcrumb my-2">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Admin Home</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Jobs</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.show', $labour->labourable->job->id) }}">{{ $labour->labourable->job->number }}</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.invoices.show', [$labour->labourable->job->id, $labour->labourable->id]) }}">Invoice</a></li>
		<li class="breadcrumb-item active">Edit Labour</li>
	</ol>
@endsection

@section('page-content')
	<form 	action="{{ route('jobs.invoices.labour.update', [$labour->labourable->job->id, $labour->labourable->id, $labour->id]) }}"
			method="POST"
			enctype="multipart/form-data">
		{{ csrf_field() }}
		{{ method_field( 'PATCH' ) }}
		<div class="form-group">
			<label 	for="labourCount" 
					{{ $errors->has('count') ? 'text-danger' :'' }}>
				Hour Count
			</label>
			<input 	type="number"
					name="count"
					class="form-control {{ $errors->has('count') ? 'is-invalid' :'' }}"
					id="labourCount"
					value="{{ old('count', $labour->count) }}"
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
					value="{{ old('description', $labour->description) }}"
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
						value="{{ old('wage', $labour->wage) }}"
						autocomplete="off"
						step="any"
						placeholder="Ex: 15.00">
			</div><!-- /input-group -->
			<small class="form-text {{ $errors->has('wage') ? 'invalid-feedback' :'' }}">
				Optional.
			</small>
		</div>
		<div class="form-group">
			<button class="btn btn-primary" type="submit">Update</button>
			<a class="btn btn-outline-primary" href="{{ route('jobs.invoices.show', [$labour->labourable->job->id, $labour->labourable->id]) }}">
				Cancel
			</a>
		</div>
	</form>
	<form 	id="labour-delete" 
			method="POST"
			action="{{ route('jobs.invoices.labour.destroy', [$labour->labourable->job->id, $labour->labourable->id, $labour->id]) }}"
			enctype="multipart">
		{{ csrf_field() }}
		{{ method_field('DELETE') }}
	</form>
	<div class="form-group">
		<button 	data-toggle="modal"
					type="button"
					data-target="#confirmModal"
					data-titletext = "Delete Labour Entry"
					data-formid="labour-delete"
					class="btn btn-outline-danger btn-block">
			Delete
		</button>
	</div>
@stop

@section('page-script')
@include('partials.modal-confirm')
@stop