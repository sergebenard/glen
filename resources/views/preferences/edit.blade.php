@extends('layouts.admin')

@section('page-title', 'Edit Preferences')

@section('page-breadcrumbs')
	<ol class="breadcrumb my-2">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Admin Home</a></li>
		<li class="breadcrumb-item active">Edit Preferences</li>
	</ol>
@endsection

@section('page-content')
	<form 	action="{{ route('preferences.update', $preference->id) }}"
			method="POST"
			enctype="multipart/form-data">
		{{ csrf_field() }}
		{{ method_field( 'PATCH' ) }}
		<div class="form-group">
			<label 	for="preferencesEmail" 
					{{ $errors->has('email') ? 'text-danger' :'' }}>
				Site Email
			</label>
			<input 	type="email"
					name="email"
					class="form-control {{ $errors->has('email') ? 'is-invalid' :'' }}"
					id="preferencesEmail"
					value="{{ old('email', $preference->email) }}"
					autocomplete="off">
			<small class="form-text {{ $errors->has('email') ? 'invalid-feedback' :'' }}">
				Optional.
			</small>
		</div>
		<div class="form-group">
			<label 	for="preferencesPhone" 
					{{ $errors->has('phone') ? 'text-danger' :'' }}>
				Site Phone
			</label>
			<input 	type="number"
					name="phone"
					class="form-control {{ $errors->has('phone') ? 'is-invalid' :'' }}"
					id="preferencesPhone"
					value="{{ old('phone', $preference->phone) }}" 
					autocomplete="off">
			<small class="form-text {{ $errors->has('phone') ? 'invalid-feedback' :'' }}">
				Optional.
			</small>
		</div>
		<div class="form-group">
			<label 	for="preferencesAddress" 
					{{ $errors->has('address') ? 'text-danger' :'' }}>
				Site Address
			</label>
			<textarea 	type="text"
						name="address"
						class="form-control {{ $errors->has('address') ? 'is-invalid' :'' }}"
						id="preferencesAddress"
						autocomplete="off">{{ old('address', $preference->address) }}</textarea>
			<small class="form-text {{ $errors->has('address') ? 'invalid-feedback' :'' }}">
				Optional.
			</small>
		</div>
		<div class="form-group">
			<label 	for="preferencesMarkup" 
					{{ $errors->has('markup') ? 'text-danger' :'' }}>
				Material Markup
			</label>
			<div class="input-group">
				<input 	type="number"
						name="markup"
						class="form-control {{ $errors->has('markup') ? 'is-invalid' :'' }}"
						id="preferencesMarkup"
						value="{{ old('markup', $preference->markup) }}"
						autocomplete="off"
						step="any"
						placeholder="Ex: 15.0">
				<div class="input-group-addon {{ $errors->has('markup') ? 'bg-danger text-white' :'' }}">%</div>
			</div><!-- /input-group -->
			<small class="form-text {{ $errors->has('markup') ? 'invalid-feedback' :'' }}">
				Optional.
			</small>
		</div>
		<div class="form-group">
			<button class="btn btn-primary" type="submit">Update</button>
			<a class="btn btn-outline-primary" href="{{ route('preferences.show', $preference->id) }}">
				Cancel
			</a>
		</div>
	</form>
@stop