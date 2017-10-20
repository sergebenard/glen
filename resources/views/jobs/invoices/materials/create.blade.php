@extends('layouts.admin')

@section('page-title', 'Add Material')

@section('page-breadcrumbs')
	<ol class="breadcrumb my-2">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Admin Home</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Jobs</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.show', $job->id) }}">{{ $job->number }}</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.invoices.show', [$job->id, $invoice->id]) }}">Invoice</a></li>
		<li class="breadcrumb-item active">New Material</li>
	</ol>
@endsection

@section('page-content')
	<form 	action="{{ route('jobs.invoices.materials.store', [$job->id, $invoice->id] ) }}"
			method="POST"
			enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="form-group">
			<label 	for="materialAmount" 
					{{ $errors->has('count') ? 'text-danger' :'' }}>
				Item Count
			</label>
			<input 	type="number"
					name="count"
					class="form-control {{ $errors->has('count') ? 'is-invalid' :'' }}"
					id="materialAmount"
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
			<label 	for="materialName" 
					{{ $errors->has('name') ? 'text-danger' :'' }}>
				Item Name
			</label>
			<input 	type="text"
					name="name"
					class="form-control {{ $errors->has('name') ? 'is-invalid' :'' }}"
					id="materialName"
					value="{{ old('name') }}"
					autocomplete="off"
					placeholder="Ex: Roll Flatstock or Box Screws" 
					required>
			<small class="form-text {{ $errors->has('name') ? 'invalid-feedback' :'' }}">
				Required.
			</small>
		</div>
		<div class="form-group">
			<label 	for="materialDescription" 
					{{ $errors->has('description') ? 'text-danger' :'' }}>
				Item Description
			</label>
			<input 	type="text"
					name="description"
					class="form-control {{ $errors->has('description') ? 'is-invalid' :'' }}"
					id="materialDescription"
					value="{{ old('description') }}"
					autocomplete="off"
					placeholder="Ex: White or Brown or Construction">
			<small class="form-text {{ $errors->has('description') ? 'invalid-feedback' :'' }}">
				Optional.
			</small>
		</div>
		<div class="form-group">
			<label 	for="materialName" 
					{{ $errors->has('cost') ? 'text-danger' :'' }}>
				Item Cost
			</label>
			<div class="input-group">
				<div class="input-group-addon {{ $errors->has('cost') ? 'bg-danger text-white' :'' }}">$</div>
				<input 	type="number"
						name="cost"
						class="form-control {{ $errors->has('cost') ? 'is-invalid' :'' }}"
						id="materialName"
						value="{{ old('cost') }}"
						autocomplete="off"
						step="any"
						placeholder="Ex: 15.00">
			</div><!-- /input-group -->
			<div class="clearfix">
			</div>
			<small class="form-text {{ $errors->has('cost') ? 'invalid-feedback' :'' }}">
				Optional.
			</small>
		</div>

		<button class="btn btn-primary" type="submit">Save New</button>
		<a class="btn btn-outline-primary" href="{{ route('jobs.invoices.show', [$job->id, $invoice->id]) }}">
			Cancel
		</a>
	</form>
@stop