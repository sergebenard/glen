@extends('layouts.admin')

@section('page-title', 'Jobs')

@section('page-breadcrumbs')
	<ol class="breadcrumb my-2">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Admin Home</a></li>
		<li class="breadcrumb-item active">Jobs</li>
	</ol>
@endsection

@section('page-content')
	<a class="btn btn-primary btn-block" href="{{ route('jobs.invoices.materials.create', $job->id, $invoice->id) }}">
		New Material
	</a>
	<a class="btn btn-primary btn-block" href="{{ route('jobs.invoices.labour.create', $job->id, $invoice->id) }}">
		New Labour
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