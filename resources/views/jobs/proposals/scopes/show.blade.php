@extends('layouts.admin')

@section('page-title', 'Job ' .$job->number .' Details')

@section('page-breadcrumbs')
	<ol class="breadcrumb my-2">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Admin Home</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Jobs</a></li>
		<li class="breadcrumb-item active">{{ $job->number }} Details</li>
	</ol>
@endsection

@section('page-content')
	<div class="row">
		<div class="col-md-8">
			<div class="card my-3">
				<a href="https://www.google.ca/maps/place/{{ urlencode( $job->address ) }}" rel="noreferrer" rel="noopener" target="_blank">
				<img 	class="card-img-top"
						src="https://maps.googleapis.com/maps/api/staticmap?size=512x512&scale=2&maptype=roadmap\&markers=size:mid%7Ccolor:red%7C{{ urlencode( $job->address ) }}&key=AIzaSyC3uTBSLuDdTdq_XSYPXhNR5Y1EwiPClFw" alt="Address">
				</a>
				<div class="card-header">
					<div class="h4 mb-1">
						{{ $job->number }}
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
						<a href="https://www.google.ca/maps/place/{{ urlencode( $job->address ) }}" rel="noreferrer" rel="noopener" target="_blank">
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
					<button 	type="button" 
								data-toggle="modal"
								data-target="#confirmModal"
								data-record="{{ $job->id }}"
								data-number="{{ $job->number }}"
								class="btn btn-outline-danger">
						<i class="fa fa-trash" aria-hidden="true"></i>
						Delete
					</button>
					<form 	id="deleteJob"
							action="{{ route('jobs.destroy', $job->id) }}"
							method="POST"
							enctype="multipart/form-data">
						{{ csrf_field() }}
						{{ method_field( 'DELETE' ) }}
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row">
				<div class="col-12">
					<div class="card my-3">
						<div class="card-header">
							<div class="h5 mb-1">
								Proposals
							</div>
						</div>
						<ul class="list-group list-group-flush">
							<li class="list-group-item list-group-item-warning">
								<div class="list-group-item-heading">
									Proposal 1
									<a 	class="btn btn-outline-primary btn-sm float-right mx-auto"
										href="#">
										Edit
									</a>
								</div>
								<small class="text-muted">
									$370 Labor, $422 Material = $792
								</small>
								-
								<small class="text-danger">
									Refused
								</small>
							</li>
							<li class="list-group-item list-group-item-success">
								<div class="list-group-item-heading">
									Proposal 2
									<a 	class="btn btn-outline-primary btn-sm float-right"
										href="#">
										Edit
									</a>
								</div>
								<small class="text-muted">
									$380 Labor, $422 Material = $802
								</small>
								-
								<small class="text-success">
									Approved
								</small>
							</li>
						</ul>
						<div class="card-footer">
							<a 	class="btn btn-outline-primary btn-block" 
								href="#">
								New
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card my-3">
						<div class="card-header">
							<div class="h5 mb-1">
								Invoices
							</div>
						</div>
						<ul class="list-group list-group-flush">
							<li class="list-group-item list-group-item-warning">
								<div class="list-group-item-heading">
									Invoice 1
									<a 	class="btn btn-outline-primary btn-sm float-right"
										href="#">
										Edit
									</a>
								</div>
								<small class="text-muted">
									$380 Labor, $422 Material = $802
								</small>
								-
								<small class="text-danger">
									Unsent
								</small>
							</li>
						</ul>
						<div class="card-footer">
							<a 	class="btn btn-outline-primary btn-block" 
								href="#">
								New
							</a>
						</div>
					</div>
				</div>

			</div>

			<div class="row">
				<div class="col-12">
					<div class="card my-3">
						<div class="card-header">
							<div class="h5 mb-1">
								Actual
							</div>
						</div>
						<ul class="list-group list-group-flush">
							<li class="list-group-item list-group-item-info">
								<div class="list-group-item-heading">
									Material
								</div>
							</li>
							<li class="list-group-item p-0">
								<table class="table table-sm mb-0">
									<tbody>
										<tr>
											<td class="small text-right" scope="row">
												1
											</td>
											<td class="small">
												Roll
											</td>
											<td class="small">
												Flatstock-White
											</td>
											<td class="small text-right">
												@&nbsp;$125.22
											</td>
											<th class="small text-right">
												=&nbsp;$125.22
											</th>
										</tr>
										<tr>
											<td class="small text-right" scope="row">
												3
											</td>
											<td class="small">
												Boxes
											</td>
											<td class="small">
												Wood Screws
											</td>
											<td class="small text-right">
												@ $17.53
											</td>
											<th class="small text-right">
												= $52.59
											</th>
										</tr>
										<tr>
											<td class="small text-right" scope="row">
												2
											</td>
											<td class="small">
												Boxes
											</td>
											<td class="small">
												Siding-Mocha
											</td>
											<td class="small text-right">
												@ $97.73
											</td>
											<th class="small text-right">
												= $194.00
											</th>
										</tr>
										<tr class="table-dark">
											<th class="small text-right" colspan="4">
												Total
											</th>
											<th class="small text-right">
												$371.81
											</th>
										</tr>
									</tbody>
								</table>
								<a 	class="btn btn-outline-info btn-block btn-sm mb-3" 
									href="{{ route('materials.create', [ 'job', $job->id ] ) }}">
									New
								</a>
								<hr>
							</li>
							<li class="list-group-item list-group-item-info">
								<div class="list-group-item-heading">
									Labour
								</div>
							</li>
							<li class="list-group-item p-0">
								<table class="table table-sm mb-0">
									<tbody>
										<tr>
											<td class="small text-right" scope="row">
												3&nbsp;hrs
											</td>
											<td class="small">
												Clearing Debris
											</td>
											<td class="small">
												@&nbsp;$15/hr
											</td>
											<th class="small text-right">
												=&nbsp;$45
											</th>
										</tr>
										<tr>
											<td class="small text-right" scope="row">
												0.5&nbsp;hrs
											</td>
											<td class="small">
												Flashing Repair
											</td>
											<td class="small">
												@&nbsp;$40/hr
											</td>
											<th class="small text-right">
												=&nbsp;$20
											</th>
										</tr>
										<tr class="table-dark">
											<th class="small text-right" colspan="3">
												Total
											</th>
											<th class="small text-right">
												$65
											</th>
										</tr>
									</tbody>
								</table>
								<a 	class="btn btn-outline-info btn-block btn-sm" 
									href="#">
									New
								</a>
							</li>
						</ul>
					</div>
				</div>

			</div>
		</div>
	</div>
	<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="confirmModal">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Deleting Job {{ $job->number }}</h5>
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
				
		$('#btnModalConfirm').click( function() {

			$('#deleteJob').submit();
		});

	})
</script>
@endsection