@extends('layouts.admin')

@section('page-title', 'Job ' .$job->number .' Proposal')

@section('page-breadcrumbs')
	<ol class="breadcrumb my-2">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Admin Home</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Jobs</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.show', $job->id) }}">{{ $job->number }}</a></li>
		<li class="breadcrumb-item active">Proposal</li>
	</ol>
@endsection

@section('page-content')
		<div class="row">
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header">
						<h3>
							Materials
						</h3>
					</div>
					<table class="table table-sm mb-0">
						<tbody>
						@if( count( $proposal->materials ) >= 1 )
							@foreach( $proposal->materials as $material )
							<tr>
								<td class="small text-right" scope="row">
									<form 	method="POST"
											id="material-{{ $material->id }}"
											action="{{ route('jobs.proposals.materials.destroy', [ $job->id, $proposal->id, $material->id ]) }}"
											enctype="multipart/data">
										{{ csrf_field() }}
										{{ method_field('DELETE') }}
									</form>
									<button 	data-toggle="modal"
												type="button" 
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
									<a 	href="{{ route('jobs.proposals.materials.edit', [$job->id, $proposal->id, $material->id]) }}">
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
									@if( !empty( $material->cost ) )
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
									@if( $proposal->materials->sum('subtotal') > 0 )
									${{ number_format( $proposal->materials->sum('subtotal'), 2, '.', '' ) }}
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
					<div class="card-footer">
						<a 	class="btn btn-outline-primary btn-block" 
							href="{{ route('jobs.proposals.materials.create', [$job->id, $proposal->id] ) }}">
							New
						</a>
					</div>
				</div>
			</div>
			<div class=" col-lg-6">
				<div class="card">
					<div class="card-header">
						<h3>
							Labour
						</h3>
					</div><!-- /card-header -->
					<table class="table table-sm mb-0">
						<tbody>
						@if( count( $proposal->labour ) >= 1 )
							@foreach( $proposal->labour as $labour )
							<tr>
								<td class="small text-right" scope="row">
									<form 	method="POST"
											id="labour-{{ $labour->id }}"
											action="{{ route('jobs.proposals.labour.destroy', [ $job->id, $proposal->id, $labour->id ]) }}"
											enctype="multipart/data">
										{{ csrf_field() }}
										{{ method_field('DELETE') }}
									</form>
									<button 	data-toggle="modal"
												type="button" 
												data-target="#confirmModal"
												data-titletext = "Delete Labour"
												data-formid="labour-{{ $labour->id }}"
												class="btn btn-outline-danger p-0 px-1">
										<span class="fa fa-trash" aria-hidden="true" aria-label="Delete"></span>
									</button>
								</td>
								<td class="small text-right">
									{{ $labour->count }}&nbsp;<sup>/{{ str_plural( 'hr', $labour->count ) }}</sup>
								</td>
								<td class="small">
									<a href="{{ route('jobs.proposals.labour.edit', [$job->id, $proposal->id, $labour->id]) }}">
										{{ $labour->description }}
									</a>
								</td>
								<td class="small text-right">
								@if( !empty($labour->wage) )
									${{ $labour->wage }}
								@endif
								</td>
								<th class="small text-right table-active">
								@if( !empty($labour->wage) )
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
									@if( $proposal->labour->sum('subtotal') > 0 )
									${{ number_format( $proposal->labour->sum('subtotal'), 2, '.', '' ) }}
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
					<div class="card-footer">
						<a 	class="btn btn-outline-primary btn-block" 
							href="{{ route('jobs.proposals.labour.create', [$job->id, $proposal->id]) }}">
							New
						</a>
					</div>
				</div><!-- /card -->
			</div>
		</div>
@stop

@section('page-script')
@include('partials.modal-confirm')
@stop