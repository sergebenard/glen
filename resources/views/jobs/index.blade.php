@extends('layouts.admin')

@section('page-title', 'Jobs')

@section('page-breadcrumbs')
	<ol class="breadcrumb my-2">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Admin Home</a></li>
		<li class="breadcrumb-item active">Jobs</li>
	</ol>
@endsection

@section('page-content')
	<a class="btn btn-primary btn-block" href="{{ route('jobs.create') }}">
		New Job
	</a>

	@empty( $jobs->all() )
		@component('partials.empty')
			jobs
		@endcomponent
	@endempty

	@foreach( $jobs as $job )
	<div class="card my-3 {{ ($job->isLate()) ? 'border-danger' : '' }}">
		<div class="card-header">
			<div class="h4 mb-1">
				<a href="{{ route('jobs.show', $job->id) }}">
					{{ $job->number }}
				</a>
			</div>
			<small class="text-muted">
				Created:
					{{ $job->created_at->diffForHumans() }}
			</small>
			<br>
			<small class="{{ ($job->isLate()) ? 'text-danger' : 'text-muted' }}">
				@if( $job->deadline !== null )
					Deadline: {{ $job->deadline->diffForHumans() }}
				@else
					No deadline specified.
				@endif
			</small>
			<br>
			<small class="text-muted">
				@if( $job->finished !== null )
					Finished: {{ $job->finished->diffForHumans() }}
				@else
					Not finished.
				@endif
			</small>
		</div>
		@if( !empty( $job->note ) )
		<div class="card-body text-muted text-truncate">
			{!! nl2br( $job->note ) !!}
		</div>
		@endif
		<ul class="list-group list-group-flush">
			@if( !empty( $job->name ) )
			<li class="list-group-item">{{ $job->name }}</li>
			@endif
			@if( !empty( $job->address ) )
			<li class="list-group-item">
				<a href="https://maps.google.com?q={{ urlencode( $job->address ) }}" rel="noreferrer" rel="noopener" target="_blank">
					{{ $job->address }}
				</a>
			</li>
			@endif
			@if( !empty( $job->phone ) )
			<li class="list-group-item">
				<a href="tel:{{ $job->phone }}">
					{{ $job->formatPhoneNumber( $job->phone ) }}
				</a>
				@if( !empty( $job->extension ) )
				<small class="text-muted">
					ext: {{ $job->extension }}
				</small>
				@endif
			</li>
			@endif
			@if( !empty( $job->email ) )
			<li class="list-group-item">
				<a href="mailto:{{ $job->email }}">
					{{ $job->email }}
				</a>
			</li>
			@endif
		</ul>
		<div class="card-footer">
			<a class="btn btn-outline-primary" href="{{ route( 'jobs.edit', $job->id ) }}">
				<i class="fa fa-pencil" aria-hidden="true"></i>
				Edit
			</a>
			<button 	data-toggle="modal"
						data-target="#confirmModal"
						data-titletext = "Delete Job"
						data-formid="job-{{ $job->id }}"
						class="btn btn-outline-danger">
				<i class="fa fa-trash" aria-hidden="true"></i>
				Delete
			</button>
			<form 	id="job-{{ $job->id }}"
					action="{{ route('jobs.destroy', $job->id) }}"
					method="POST"
					enctype="multipart/form-data">
				{{ csrf_field() }}
				{{ method_field( 'DELETE' ) }}
			</form>
		</div>
	</div>
	@endforeach
	<a class="btn btn-primary btn-block" href="{{ route('jobs.create') }}">
		New Job
	</a>
@stop

@section('page-script')
@include('partials.modal-confirm')
@endsection