@extends('layouts.admin')

@section('page-title', 'Edit Labour')

@section('page-breadcrumbs')
	<ol class="breadcrumb my-2">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Admin Home</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Jobs</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.show', $job->id) }}">{{ $job->number }}</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.invoices.show', [$job->id, $invoice->id]) }}">Invoice</a></li>
		<li class="breadcrumb-item active">Edit Labour</li>
	</ol>
@endsection

@section('page-content')
	<form 	action="{{ route('jobs.invoices.labour.update', [$job->id, $invoice->id, $labour->id]) }}"
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
			<a class="btn btn-outline-primary" href="{{ route('jobs.invoices.show', [$job->id, $invoice->id]) }}">
				Cancel
			</a>
		</div>
		<div class="form-group">
			<button 	type="button"
						class="btn btn-outline-danger btn-block"
						data-toggle="modal"
						data-target="#confirmModal">
				Delete
			</button>
		</div>
	</form>

	<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="confirmModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Deleting Labour</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to delete this labour entry?</p>
				</div>
				<div class="modal-footer">
					<form 	action="{{ route('jobs.invoices.labour.destroy', [$job->id, $invoice->id, $labour->id]) }}"
							method="POST"
							enctype="multipart/data">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}
						<button 	type="submit" 
									id="btnModalConfirm" 
									class="btn btn-primary">
							Yes
						</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop