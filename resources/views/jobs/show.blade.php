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
				<a href="https://www.google.com/maps/place/{{ urlencode( $job->address ) }}" rel="noreferrer" rel="noopener" target="_blank">
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
							<a name="jobProposals"></a>
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
							<a name="jobInvoices"></a>
							<div class="h5 mb-1">
								Invoices
							</div>
						</div>
						<ul class="list-group list-group-flush">
						@foreach( $job->invoices as $invoice )
							<li class="list-group-item {{ ( $invoice->sent && $invoice->paid ) ? 'list-group-item-success' : 'list-group-item-warning' }}">
								<div class="list-group-item-heading">
									<a href="{{ route('jobs.invoices.show', [$job->id, $invoice->id]) }}" >
										Invoice {{ $loop->iteration }}
									</a>	
								</div>
								<small class="text-muted">
									${{ $jobInvoicesMaterialsSum = number_format( $invoice->materials->sum('subtotal'), 2, '.', '' ) }}
										Material,
									${{ $jobInvoicesLabourSum = number_format( $invoice->labour->sum('subtotal'), 2, '.', '' ) }}
										Labour =
									${{ number_format( $jobInvoicesMaterialsSum + $jobInvoicesLabourSum, 2, '.', '' ) }}
								</small>
								<div class="btn-toolbar">
									<form 	method="POST"
											action="{{ route('jobs.invoices.destroy', [$job->id, $invoice->id]) }}"
											enctype="multipart">
										{{ csrf_field() }}
										{{ method_field('DELETE') }}
										<div class="btn-group btn-group-sm mr-2">
											<a 	class="btn btn-outline-primary"
												href="{{ route('jobs.invoices.show', [$job->id, $invoice->id]) }}">
												Edit
											</a>
											<button class="btn btn-outline-danger"
													type="submit">
												Delete
											</button>
										</div>
										<div class="btn-group btn-group-sm">
											@if ( $invoice->sent )
											<button	class="btn btn-outline-success disabled">
												Sent
											</button>
											@else
											<div class="btn-group btn-group-sm" role="group">
												<button type="button" class="btn btn-outline-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Unsent
												</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="{{ route('jobs.invoices.send', [$job->id, $invoice->id]) }}">
														Send with detailed breakdown.
													</a>
													<a class="dropdown-item" href="{{ route('jobs.invoices.send', [$job->id, $invoice->id]) }}">
														Send with summary only.
													</a>
												</div>
											</div>
											@endif
											@if ( $invoice->paid )
											<button	class="btn btn-outline-success disabled">
												Paid
											</button>
											@else
											<a 	class="btn btn-outline-danger"
												href="{{ route('jobs.invoices.pay', [$job->id, $invoice->id]) }}">
												Unpaid
											</a>
											@endif
										</div>

							</li>
						@endforeach
						@if( $job->invoices->count() < 1 )
							<li class="list-group-item">
								No Invoices.
							</li>
						@endif
						</ul>
						<div class="card-footer">
							<a 	class="btn btn-outline-primary btn-block" 
								href="{{ route('jobs.invoices.create', $job->id) }}">
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
							<a name="jobActual"></a>
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
									@if( count( $job->materials ) >= 1 )
										@foreach( $job->materials as $material )
										<tr>
											<td class="small text-right" scope="row">
												<form 	method="POST"
														id="formDeleteMaterial-{{ $material->id }}"
														action="{{ route('jobs.materials.destroy', [ $job->id, $material->id ]) }}"
														enctype="multipart/data">
													{{ csrf_field() }}
													{{ method_field('DELETE') }}
													<button class="btn btn-outline-danger p-0 px-1">
														<span class="fa fa-trash" aria-hidden="true" aria-label="Delete"></span>
													</button>
												</form>
											</td>
											<td class="small text-right">
												{{ $material->count }}
											</td>
											<td class="small">
												<a 	href="{{ route('jobs.materials.edit', [$job->id, $material->id]) }}">
													{{ $material->name }}
												</a>
											</td>
											<td class="small">
												{{ $material->description }}
											</td>
											<td class="small text-right">
												@if( !empty( $material->cost ) )
												@&nbsp;${{ $material->cost }}
												@endif
											</td>
											<th class="small text-right table-active">
												@if( !empty( $material->subtotal ) )
												${{ $material->subtotal }}
												@endif
											</th>
										</tr>
										@endforeach
										<tr class="table-dark">
											<th class="small text-right" colspan="5">
												Total
											</th>
											<th class="small text-right">
												@if( $job->materials->sum('subtotal') > 0 )
												${{ number_format( $job->materials->sum('subtotal'), 2, '.', '' ) }}
												@endif
											</th>
										</tr>
									@else
										<tr>
											<td class="text-center">
												No materials.
											</td>
										</tr>
									@endif
									</tbody>
								</table>
								<a 	class="btn btn-outline-info btn-block btn-sm mb-3" 
									href="{{ route('jobs.materials.create', $job->id ) }}">
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
									@if( count( $job->labour ) >= 1 )
										@foreach( $job->labour as $labour )
										<tr>
											<td class="small text-right" scope="row">
												<form 	method="POST"
														id="formDeleteLabour-{{ $labour->id }}"
														action="{{ route('jobs.labour.destroy', [ $job->id, $labour->id ]) }}"
														enctype="multipart/data">
													{{ csrf_field() }}
													{{ method_field('DELETE') }}
													<button class="btn btn-outline-danger p-0 px-1">
														<span class="fa fa-trash" aria-hidden="true" aria-label="Delete"></span>
													</button>
												</form>
											</td>
											<td class="small text-right">
												{{ $labour->count }}&nbsp;<sup>hrs</sup>
											</td>
											<td class="small">
												<a href="{{ route('jobs.labour.edit', [$job->id, $labour->id]) }}">
													{{ $labour->description }}
												</a>
											</td>
											<td class="small text-right">
											@if( !empty($labour->wage) )
												${{ $labour->wage }}&nbsp;<sup>/hr</sup>
											@endif
											</td>
											<th class="small text-right table-active">
											@if( !empty($labour->subtotal) )
												${{ $labour->subtotal }}
											@endif
											</th>
										</tr>
										@endforeach
										<tr class="table-dark">
											<th class="small text-right" colspan="4">
												Total
											</th>
											<th class="small text-right">
												@if( $job->labour->sum('subtotal') > 0 )
												${{ number_format( $job->labour->sum('subtotal'), 2, '.', '' ) }}
												@endif
											</th>
										</tr>
									@else
										<tr>
											<td class="text-center">
												No labour.
											</td>
										</tr>
									@endif
									</tbody>
								</table>
								<a 	class="btn btn-outline-info btn-block btn-sm" 
									href="{{ route('jobs.labour.create', $job->id) }}">
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
				<form 	method="POST"
						id="formDeletelabour-{{ $job->id }}"
						action="{{ route('jobs.destroy', $job->id) }}"
						enctype="multipart/data">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button 	type="submit"
								class="btn btn-primary">
						Yes
					</button>
				</form>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
		</div>
	</div>
@stop