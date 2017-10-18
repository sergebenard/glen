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
	<div class="card my-3">
		<div class="card-header">
			<div class="h4 mb-1">
				<a href="{{ route('jobs.show', $job->id) }}">
					{{ $job->number }}
				</a>
			</div>
			<small class="text-muted">{{ $job->created_at->diffForHumans() }}</small>
		</div>
		@if( !empty( $job->note ) )
		<div class="card-body">
			<small>
				<pre class="card-text text-muted">{{ $job->note }}</pre>
			</small>
		</div>
		@endif
		<ul class="list-group list-group-flush">
			@if( !empty( $job->name ) )
			<li class="list-group-item">{{ $job->name }}</li>
			@endif
			@if( !empty( $job->address ) )
			<li class="list-group-item">
				<a href="https://www.google.com/maps/search/?api=1&query={{ urlencode( $job->address ) }}" rel="noreferrer" rel="noopener" target="_blank">
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
			<li class="list-group-item">{{ ($job->finished ? 'Finished' : 'Not Finished') }}</li>
		</ul>
		<div class="card-footer">
			<a class="btn btn-outline-primary" href="{{ route( 'jobs.edit', $job->id ) }}">
				<i class="fa fa-pencil" aria-hidden="true"></i>
				Edit
			</a>
			<button 	data-toggle="modal"
						data-target="#confirmModal"
						data-record="{{ $job->id }}"
						data-number="{{ $job->number }}"
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

	<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="confirmModal">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to delete this job?</p>
			</div>
			<div class="modal-footer">
				<button 	type="button" 
							id="btnModalConfirm" 
							class="btn btn-primary">
					Yes
				</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
		</div>
	</div>
@stop

@section( 'page-script' )
<script>
	$('#confirmModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var record = button.data('record'); // Extract info from data-* attributes
		var number = button.data('number');
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this);
		modal.find('.modal-title').text('Deleting Job ' + number);
		
		$('#btnModalConfirm').click( function() {

			$('#job-' + record).submit();
		});

	})
</script>
@endsection