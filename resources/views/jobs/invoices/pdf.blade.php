@extends('layouts.pdf')

@section('page-title', 'Glen Lall Invoice')

@section('page-content')
	@php
		$materialSubtotal=0;
		$labourSubtotal=0;
	@endphp
	<div class="page-wrap">
		<table class="mb-5">
			<tr>
				<td width="65%" class="text-address">
					{{ $invoice->job->name }}<br>
					{!! nl2br( $invoice->job->address ) !!}
				</td>
				<td align="right">
					<h1>
						INVOICE
					</h1>
					<p class="m-0 mb-5">{{ env('APP_NAME', 'Glen Lall') }}</p>
					<div class="text-muted">
						{{ date('D, jS \of F Y') }}	
					</div>
				</td>
			</tr>
		</table>
		<table class="table table-striped table-sm table-bordered">
			<thead>
				<tr class="table-inverse">
					<th colspan="5" class="h5">
						Materials
					</th>
				</tr>
				<tr>
					<th class="text-right">
						Count
					</th>
					<th class="w-50">
						Name
					</th>
					<th class="w-50" @if( session('details') == '' ) colspan="3" @endif>
						Description
					</th>
					@if( session('details') != '' )
					<th class="text-right">
						Cost
					</th>
					<th class="table-active text-right">
						Sub
					</th>
					@endif
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
					<td @if( session('details') == '' ) colspan="3" @endif>
						{{ $material->description }}
					</td>
					@if( session('details') != '')
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
					@endif
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr class="table-dark">
					<th class="text-right" colspan="4">
						Materials Subtotal
					</th>
					<th class="text-right">
						@if( $invoice->materials->sum('subtotal') > 0 )
						${{ $materialSubtotal = number_format( $invoice->materials->sum('subtotal'), 2, '.', '' ) }}
						@endif
					</th>
				</tr>
			</tfoot>
			@else
			<tfoot>
				<tr>
					<td colspan="5" class="text-center">
						No materials.
					</td>
				</tr>
			</tfoot>
			@endif
			<thead>
				<tr class="table-inverse">
					<th colspan="5" class="h5">
						Labour
					</th>
				</tr>
				<tr>
					<th class="text-right">
						Count
					</th>
					<th @if(session('details') == '') colspan="4" @else colspan="2" @endif>
						Description
					</th>
					@if(session('details') != '')
					<th class="text-right">
						Cost
					</th>
					<th class="table-active text-right">
						Sub
					</th>
					@endif
				</tr>
			</thead>
			<tbody>
			@if( count( $invoice->labour ) >= 1 )
				@foreach( $invoice->labour as $labour )
				<tr>
					<td class="text-right">
						{{ $labour->count }}&nbsp;{{ str_plural( 'hr', $labour->count ) }}
					</td>
					<td @if(session('details') == '') colspan="4" @else colspan="2" @endif>
						{{ $labour->description }}
					</td>
					@if(session('details') != '')
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
					@endif
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr class="table-dark">
					<th class="text-right" colspan="4">
						Labour Subtotal
					</th>
					<th class="text-right">
						@if( $invoice->labour->sum('subtotal') > 0 )
						${{ $labourSubtotal = number_format( $invoice->labour->sum('subtotal'), 2, '.', '' ) }}
						@endif
					</th>
				</tr>
			@else
			<tfoot>
				<tr>
					<td colspan="5" class="text-center">
						No labour.
					</td>
				</tr>
			</tfoot>
			@endif
			<tfoot>
				<tr class="table-total">
					<th colspan="4" class="text-right">
						Total
					</th>
					<th class="text-right">
						${{ number_format( $materialSubtotal + $labourSubtotal, 2, '.', '' ) }}
					</th>
				</tr>
			</tfoot>
		</table>
	</div>
	<table class="table site-footer">
		<thead>
			<tr class="table-inverse">
				<th>
					How To Pay Your Invoice
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<p>You have a few options. You can pay using:</p>
					<ul>
						<li>
							email
						</li>
						<li>
							Cheque
						</li>
					</ul>
				</td>
			</tr>
		</tbody>
	</table>
@stop