@extends('layouts.printout')

@section('page-title', 'Glen Lall Invoice')

@section('page-controls')
	<div class="alert alert-info d-print-none">
		<h4>
			This box will not be printed out.
		</h4>
		<form method="POST" action="">
			{{ csrf_field() }}
			<div class="form-check">
				<label class="form-check-label custom-control custom-checkbox">
					<input 	type="checkbox"
							name="materialDetails"
							value="details" {{ isset( $request->materialDetails ) && $request->materialDetails == 'details' ? 'checked' : '' }}
							class="custom-control-input">
					<span class="custom-control-indicator"></span>
					<div class="custom-control-description">
						Detailed Materials
					</div>
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label custom-control custom-checkbox">
					<input 	type="checkbox"
							name="labourDetails"
							value="details" {{ isset( $request->labourDetails ) && $request->labourDetails == 'details' ? 'checked' : '' }}
							class="custom-control-input">
					<span class="custom-control-indicator"></span>
					<div class="custom-control-description">
						Detailed Labour
					</div>
				</label>
			</div>
			<button 	type="submit"
						class="btn btn-outline-primary">
				Update Invoice
			</button>
		</form>
	</div>

@stop

@section('page-content')
	@php
		$materialSubtotal=0;
		$labourSubtotal=0;
	@endphp
	<div class="row mb-3">
		<div class="col-4">
			<div class="align-bottom">
				<p>
					{{ $invoice->job->name }}<br>
					{!! nl2br( $invoice->job->address ) !!}
				</p>
			</div>
		</div>
		<div class="col-8">
			<div class="text-right">
				<div class="display-4 mb-3">
					INVOICE
				</div>
				<div class="text-muted">
					{{ date('D, jS \of F Y') }}	
				</div>
			</div>
		</div>
	</div><!-- /.row -->
		<table class="table table-striped table-sm table-bordered">
			<thead>
				<tr class="table-inverse">
					<th colspan="5" class="h5">
						Materials
					</th>
				</tr>
				<tr>
					<th>
						Count
					</th>
					<th class="w-50">
						Name
					</th>
					<th class="w-50">
						Description
					</th>
					<th class="text-right">
						Cost
					</th>
					<th class="table-active text-right">
						Sub
					</th>
				</tr>
			</thead>
			<tbody>
				@if( count( $invoice->materials ) >= 1 )
					@foreach( $invoice->materials as $material )
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
							Subtotal
						</th>
						<th class="text-right">
							@if( $invoice->materials->sum('subtotal') > 0 )
							${{ $materialSubtotal = number_format( $invoice->materials->sum('subtotal'), 2, '.', '' ) }}
							@endif
						</th>
					</tr>
				@else
					<tr>
						<td colspan="5" class="text-center">
							No materials.
						</td>
					</tr>
				@endif
			</tbody>
			<thead>
				<tr class="table-inverse">
					<th colspan="5" class="h5">
						Labour
					</th>
				</tr>
				<tr>
					<th>
						Count
					</th>
					<th colspan="2">
						Description
					</th>
					<th class="text-right">
						Cost
					</th>
					<th class="table-active text-right">
						Sub
					</th>
				</tr>
			</thead>
			<tbody>
			@if( count( $invoice->labour ) >= 1 )
				@foreach( $invoice->labour as $labour )
				<tr>
					<td class="text-right">
						{{ $labour->count }}&nbsp;{{ str_plural( 'hr', $labour->count ) }}
					</td>
					<td colspan="2">
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
					<th class="text-right" colspan="4">
						Subtotal
					</th>
					<th class="text-right">
						@if( $invoice->labour->sum('subtotal') > 0 )
						${{ $labourSubtotal = number_format( $invoice->labour->sum('subtotal'), 2, '.', '' ) }}
						@endif
					</th>
				</tr>
			@else
				<tr>
					<td colspan="5" class="text-center">
						No labour.
					</td>
				</tr>
			@endif
			<tr class="table-active">
				<th colspan="4" class="text-right">
					Total
				</th>
				<th class="text-right">
					${{ number_format( $materialSubtotal + $labourSubtotal, 2, '.', '' ) }}
				</th>
			</tr>
			</tbody>
		</table>
@stop