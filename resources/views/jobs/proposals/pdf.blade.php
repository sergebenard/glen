@extends('layouts.printout')

@section('page-title', 'Glen Lall Proposal')

@section('page-content')
	<div class="alert alert-info d-print-none">
		All items in blue on this page will not be printed out.
	</div>
	<div class="row">
		<div class="col-3">
			<div class="align-bottom">
				<p>
					{{ $proposal->job->name }}<br>
					{!! nl2br( $proposal->job->address ) !!}
				</p>
			</div>
		</div>
	</div>
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
								<td class="text-right">
									{{ $material->count }}
								</td>
								<td>
									{{ $material->name }}
								</td>
								<td>
									{{ $material->description }}
								</td>
								<td class="text-right">
									@if( !empty( $material->cost ) )
									@&nbsp;${{ $material->cost }}
									@endif
								</td>
								<th class="text-right table-active">
									@if( !empty( $material->cost ) )
									${{ $material->subtotal }}
									@endif
								</th>
							</tr>
							@endforeach
							<tr class="table-dark">
								<th class="text-right" colspan="4">
									Total
								</th>
								<th class="text-right">
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
								<td class="text-right">
									{{ $labour->count }}&nbsp;/{{ str_plural( 'hr', $labour->count ) }}
								</td>
								<td>
									{{ $labour->description }}
								</td>
								<td class="text-right">
								@if( !empty($labour->wage) )
									${{ $labour->wage }}
								@endif
								</td>
								<th class="text-right table-active">
								@if( !empty($labour->wage) )
									${{ $labour->subtotal }}
								@endif
								</th>
							</tr>
							@endforeach
							<tr class="table-dark">
								<th class="text-right" colspan="3">
									Total
								</th>
								<th class="text-right">
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
				</div><!-- /card -->
			</div>
		</div>
@stop