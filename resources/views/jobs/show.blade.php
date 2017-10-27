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
				<a href="https://maps.google.com?q={{ urlencode( $job->address ) }}" target="_blank">
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
				<div class="card-body text-muted">
						{!! nl2br( $job->note ) !!}
				</div>
				@endif
				<ul class="list-group list-group-flush">
					@if( !empty( $job->name ) )
					<li class="list-group-item">{{ $job->name }}</li>
					@endif
					@if( !empty( $job->address ) )
					<li class="list-group-item">
						<a href="https://maps.google.com?q={{ urlencode( $job->address ) }}" target="_blank">
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
								type="button" 
								data-target="#confirmModal"
								data-titletext = "Delete Job"
								data-formid="deleteJob"
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
						@foreach( $job->proposals as $proposal )
							@php
							$listGroupBackground = 'list-group-item-warning';
							switch( strtolower($proposal->status) )	{
								case 'approved':
									$listGroupBackground = 'list-group-item-success';
									break;
								case 'refused':
									$listGroupBackground = 'list-group-item-danger';
									break;
							}

							@endphp
							<li class="list-group-item {{ $listGroupBackground }}">
								<div class="list-group-item-heading h5">
									<a href="{{ route('jobs.proposals.show', [$job->id, $proposal->id]) }}">
										Proposal {{ $loop->iteration }}
									</a>
								</div><!-- /.list-group-item -->
								<table class="table table-sm">
									<thead>
										<tr class="table-active">
											<th scope="col">Material</th>
											<th scope="col">Labour</th>
											<th scope="col">Total</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td scope="row">
												${{ $jobProposalsMaterialsSum = number_format( $proposal->materials->sum('subtotal'), 2, '.', '' ) }}
											</td>
											<td>
												${{ $jobProposalsLabourSum = number_format( $proposal->labour->sum('subtotal'), 2, '.', '' ) }}
												
												<span class="align-baseline text-muted">
													({{ round( $proposal->labour->sum('count'), 2 ) }} {{ str_plural('hr', $proposal->labour->sum('count')) }})
												</span>
											</td>
											<th class="table-active">
												${{ number_format( $jobProposalsMaterialsSum + $jobProposalsLabourSum, 2, '.', '' ) }}
											</th>
										</tr>
									</tbody>
								</table>
								
								<div class="btn-toolbar">
									<form 	id="proposal-delete-{{ $proposal->id }}" 
											method="POST"
											action="{{ route('jobs.proposals.destroy', [$job->id, $proposal->id]) }}"
											enctype="multipart">
										{{ csrf_field() }}
										{{ method_field('DELETE') }}
									</form>
									<form 	id="proposal-toggle-send-{{ $proposal->id }}" 
											method="POST"
											action="{{ route('jobs.proposals.toggleSend', [$job->id, $proposal->id]) }}"
											enctype="multipart">
										{{ csrf_field() }}
									</form>
									<div class="btn-group btn-group-sm mr-2">
										<a 	class="btn btn-outline-primary"
											href="{{ route('jobs.proposals.show', [$job->id, $proposal->id]) }}">
											<i class="fa fa-pencil" aria-hidden="true" aria-label="Edit"></i>
										</a>
										<button 	data-toggle="modal"
													type="button" 
													data-target="#confirmModal"
													data-titletext = "Delete Proposal"
													data-formid="proposal-delete-{{ $proposal->id }}"
													class="btn btn-sm btn-outline-danger">
											<i class="fa fa-trash" aria-hidden="true" aria-label="Delete"></i>
										</button>
									</div>
									<div class="btn-group btn-group-sm">
										<button type="button" class="btn {{ $btnColour = ( $proposal->sent ) ? 'btn-success' : 'btn-outline-danger' }}">
											{{ ( $proposal->sent ) ? 'Sent' : 'Unsent' }}
										</button>
										<button type="button" class="btn {{ $btnColour }} dropdown-toggle dropdown-toggle-split mr-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<div class="dropdown-menu">
										@if( !empty( $job->email ) )
											<form 	id="proposal-send-{{ $proposal->id }}" 
													method="POST"
													action="{{ route('jobs.proposals.send', [$job->id, $proposal->id]) }}"
													enctype="multipart">
												{{ csrf_field() }}
											</form>
											<button 	data-toggle="modal"
														data-target="#confirmModal"
														data-titletext = "Email Detailed Proposal"
														data-formid="proposal-send-{{ $proposal->id }}"
														class="dropdown-item">
												Email detailed breakdown.
											</button>
											<button 	data-toggle="modal"
														data-target="#confirmModal"
														data-titletext = "Email Summary Proposal"
														data-formid="proposal-send-{{ $proposal->id }}"
														class="dropdown-item">
												Email summary only.
											</button>
											<div class="dropdown-divider"></div>
										@endif
											<a 	class="dropdown-item" 
												href="{{ route('jobs.proposals.print', [$job->id, $proposal->id]) }}"
												target="_blank">
												Print <em>Snail Mail</em> proposal
											</a>
											<button 	data-toggle="modal"
														data-target="#confirmModal"
														data-titletext = "Mark Mailed Proposal as {{ ( $proposal->sent ? 'Unsent' : 'Sent' ) }}"
														data-formid="proposal-toggle-send-{{ $proposal->id }}"
														class="dropdown-item">
												Mark proposal as {{ ( $proposal->sent ? 'unsent' : 'sent' ) }}.
											</button>
										</div>
										
										<div class="btn-group btn-group-sm">
											<button type="button" class="btn {{ $btnColour = ( $proposal->status !== 'approved' ) ? 'btn-outline-danger' : 'btn-success' }}">
												{{ ucwords( $proposal->status ) }}
											</button>
											<button type="button" class="btn {{ $btnColour }} dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<div class="dropdown-menu">
											@if( $proposal->status !== 'approved' )
												<a class="dropdown-item" href="{{ route('jobs.proposals.changeStatus', [$job->id, $proposal->id, 'approved']) }}">
													Approved
												</a>
											@endif
											@if( $proposal->status !== 'refused' )
												<a class="dropdown-item" href="{{ route('jobs.proposals.changeStatus', [$job->id, $proposal->id, 'refused']) }}">
													Refused
												</a>
											@endif
											@if( $proposal->status !== 'undecided' )
												<a class="dropdown-item" href="{{ route('jobs.proposals.changeStatus', [$job->id, $proposal->id, 'undecided']) }}">
													Undecided
												</a>
											@endif
											</div><!-- /dropdown-menu -->
										</div>
									</div>
								</div>
							</li>
						@endforeach
						@if( $job->proposals->count() < 1 )
							<li class="list-group-item text-center">
								No proposals.
							</li>
						@endif
						</ul>
						<div class="card-footer">
							<a 	class="btn btn-outline-primary btn-block" 
								href="{{ route('jobs.proposals.create', $job->id) }}">
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
							<li class="list-group-item {{ $invoice->paid ? 'list-group-item-success' : 'list-group-item-warning' }}">
								<div class="list-group-item-heading h5">
									<a 	href="{{ route('jobs.invoices.show', [$job->id, $invoice->id]) }}">
										Invoice {{ $loop->iteration }}
									</a>
								</div><!-- /.list-group-item -->
								<table class="table table-sm">
									<thead>
										<tr class="table-active">
											<th scope="col">Material</th>
											<th scope="col">Labour</th>
											<th scope="col">Total</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td scope="row">
												${{ $jobInvoicesMaterialsSum = number_format( $invoice->materials->sum('subtotal'), 2, '.', '' ) }}
											</td>
											<td>
												${{ $jobInvoicesLabourSum = number_format( $invoice->labour->sum('subtotal'), 2, '.', '' ) }}
												
												<span class="align-baseline text-muted">
													({{ round( $invoice->labour->sum('count'), 2 ) }} {{ str_plural('hr', $invoice->labour->sum('count')) }})
												</span>
											</td>
											<th class="table-active">
												${{ number_format( $jobInvoicesMaterialsSum + $jobInvoicesLabourSum, 2, '.', '' ) }}
											</th>
										</tr>
									</tbody>
								</table>
								
								<div class="btn-toolbar">
									<form 	id="invoice-delete-{{ $invoice->id }}" 
											method="POST"
											action="{{ route('jobs.invoices.destroy', [$job->id, $invoice->id]) }}"
											enctype="multipart">
										{{ csrf_field() }}
										{{ method_field('DELETE') }}
									</form>
									<form 	id="invoice-toggle-send-{{ $invoice->id }}" 
											method="POST"
											action="{{ route('jobs.invoices.toggleSend', [$job->id, $invoice->id]) }}"
											enctype="multipart">
										{{ csrf_field() }}
									</form>
									<div class="btn-group btn-group-sm mr-2">
										<a 	class="btn btn-outline-primary"
											href="{{ route('jobs.invoices.show', [$job->id, $invoice->id]) }}">
											<i class="fa fa-pencil" aria-hidden="true" aria-label="Edit"></i>
										</a>
										<button 	data-toggle="modal"
													type="button" 
													data-target="#confirmModal"
													data-titletext = "Delete Invoice"
													data-formid="invoice-delete-{{ $invoice->id }}"
													class="btn btn-sm btn-outline-danger">
											<i class="fa fa-trash" aria-hidden="true" aria-label="Delete"></i>
										</button>
									</div>
									<div class="btn-group btn-group-sm">
										<button type="button" class="btn {{ $btnColour = ( $invoice->sent ) ? 'btn-success' : 'btn-outline-danger' }}">
											{{ ( $invoice->sent ) ? 'Sent' : 'Unsent' }}
										</button>
										<button type="button" class="btn {{ $btnColour }} dropdown-toggle dropdown-toggle-split mr-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<div class="dropdown-menu">
										@if( !empty( $job->email ) )
											<form 	id="invoice-send-{{ $invoice->id }}" 
													method="POST"
													action="{{ route('jobs.invoices.send', [$job->id, $invoice->id]) }}"
													enctype="multipart">
												{{ csrf_field() }}
											</form>
											<button 	data-toggle="modal"
														data-target="#confirmModal"
														data-titletext = "Email Detailed Invoice"
														data-formid="invoice-send-{{ $invoice->id }}"
														class="dropdown-item">
												Email detailed breakdown.
											</button>
											<button 	data-toggle="modal"
														data-target="#confirmModal"
														data-titletext = "Email Summary Invoice"
														data-formid="invoice-send-{{ $invoice->id }}"
														class="dropdown-item">
												Email summary only.
											</button>
											<div class="dropdown-divider"></div>
										@endif
											<a 	class="dropdown-item" 
												href="{{ route('jobs.invoices.print', [$job->id, $invoice->id]) }}"
												target="_blank">
												Print <em>Snail Mail</em> proposal
											</a>
											<button 	data-toggle="modal"
														data-target="#confirmModal"
														data-titletext = "Mark Mailed Invoice as {{ ( $invoice->sent ? 'Unsent' : 'Sent' ) }}"
														data-formid="invoice-toggle-send-{{ $invoice->id }}"
														class="dropdown-item">
												Mark proposal as {{ ( $invoice->sent ? 'unsent' : 'sent' ) }}.
											</button>
										</div>
										
										<div class="btn-group btn-group-sm">
											<button type="button" class="btn {{ $btnColour = ( $invoice->paid ) ? 'btn-success' : 'btn-outline-danger' }}">
												{{ ( $invoice->paid ) ? 'Paid' : 'Unpaid' }}
											</button>
											<button type="button" class="btn {{ $btnColour }} dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<div class="dropdown-menu">
											@if( $invoice->paid )
												<a class="dropdown-item" href="{{ route('jobs.invoices.togglePay', [$job->id, $invoice->id]) }}">
													Mark as unpaid.
												</a>
											@else
												<a class="dropdown-item" href="{{ route('jobs.invoices.togglePay', [$job->id, $invoice->id]) }}">
													Mark as paid.
												</a>
											@endif
											</div><!-- /dropdown-menu -->
										</div>
									</div>
								</div>
							</li>
						@endforeach
						@if( $job->invoices->count() < 1 )
							<li class="list-group-item text-center">
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
														id="material-{{ $material->id }}"
														action="{{ route('jobs.materials.destroy', [ $job->id, $material->id ]) }}"
														enctype="multipart/data">
													{{ csrf_field() }}
													{{ method_field('DELETE') }}
												</form>
												<button 	data-toggle="modal"
															data-target="#confirmModal"
															data-titletext = "Delete Material"
															data-formid="material-{{ $material->id }}"
															class="btn btn-outline-danger p-0 px-1">
													<span class="fa fa-trash" aria-hidden="true" aria-label="Delete"></span>
												</button>
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
														id="labour-{{ $labour->id }}"
														action="{{ route('jobs.labour.destroy', [ $job->id, $labour->id ]) }}"
														enctype="multipart/data">
													{{ csrf_field() }}
													{{ method_field('DELETE') }}
												</form>
												
												<button 	data-toggle="modal"
															data-target="#confirmModal"
															data-titletext = "Delete Labour Entry"
															data-formid="labour-{{ $labour->id }}"
															class="btn btn-outline-danger p-0 px-1">
													<span class="fa fa-trash" aria-hidden="true" aria-label="Delete"></span>
												</button>
											</td>
											<td class="small text-right">
												{{ $labour->count }}&nbsp;<sup>{{ str_plural('hr', $labour->count) }}</sup>
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
@stop

@section('page-script')
@include('partials.modal-confirm')
@stop