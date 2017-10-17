@extends('layouts.admin')

@section('page-title', 'Edit Material')

@section('page-breadcrumbs')
	<ol class="breadcrumb my-2">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Admin Home</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Jobs</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.show', $job->id) }}">{{ $job->number }}</a></li>
		<li class="breadcrumb-item active">Edit Material</li>
	</ol>
@endsection

@section('page-content')
	<form 	action="{{ route('jobs.materials.update', [$job->id, $material->id]) }}"
			method="POST"
			enctype="multipart/form-data">
		{{ csrf_field() }}
		{{ method_field('PATCH') }}
		<div class="form-group">
			<label 	for="materialAmount" 
					{{ $errors->has('count') ? 'text-danger' :'' }}>
				Item Count
			</label>
			<input 	type="number"
					name="count"
					class="form-control {{ $errors->has('count') ? 'is-invalid' :'' }}"
					id="materialAmount"
					value="{{ old('count', '1', $material->count) }}"
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
					value="{{ old('name', $material->name) }}"
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
					value="{{ old('description', $material->description) }}"
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
						value="{{ old('cost', $material->cost) }}"
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
		<div class="form-group">
			<button class="btn btn-primary" type="submit">Update</button>
			<a class="btn btn-outline-primary" href="{{ route('jobs.show', $job->id) }}">
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
				<h5 class="modal-title">Deleting Material</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to delete this material?</p>
			</div>
			<div class="modal-footer">
				<form 	action="{{ route('jobs.materials.destroy', [$job->id, $material->id]) }}"
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