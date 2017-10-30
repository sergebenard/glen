@extends('layouts.admin')

@section('page-title', 'Admin Home')

@section('page-content')
	<div class="row">
		<div class="col-md-6 mb-3">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">
						{{ $unfinished->count() }}
						Unfinished
						{{ str_plural('Job', $unfinished->count()) }}
					</h4>
				</div>
				<ul class="list-group list-group-flush">
				@foreach( $unfinished as $job )
					<li class="list-group-item">
						<a 	href="{{ route('jobs.show', $job->id) }}" class="list-group-item-action">
							{{ $job->number }}
						</a>
					</li>
				@endforeach
				@empty( $unfinished->all() )
					<li class="list-group-item">
						<p class="list-group-item-text">
							Congratulations, no unfinished jobs!
						</p>
					</li>
				@endempty
				</ul>
				<div class="card-footer">
					<a  href="{{ route('jobs.index') }}"
						class="btn btn-outline-primary btn-block">
						View All Jobs
					</a>
				</div><!-- /.card-footer -->
			</div><!-- /.card -->
		</div><!-- /.col-md-6 -->
		<div class="col-md-6 mb-3">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">
						{{ $unpaid->count() }}
						Unpaid
						{{ str_plural('Invoice', $unpaid->count()) }}
					</h4>
				</div>
				<ul class="list-group list-group-flush">
				@php
						$materialTotal = 0;
						$labourTotal = 0;
						$total = 0;
				@endphp
				@foreach( $unpaid as $invoice )
					<li class="list-group-item">
						<div class="list-group-item-heading">
							<a 	href="{{ route('jobs.invoices.show', [$invoice->job->id, $invoice->id]) }}" class="list-group-item-action">
								{{ $invoice->job->number }}
							</a>
						</div>
						<small class="text-muted">
						@php
							$materialTotal += $invoice->materials->sum('subtotal');
							$labourTotal += $invoice->labour->sum('subtotal');
							$total += $invoice->materials->sum('subtotal') + $invoice->labour->sum('subtotal');
						@endphp
							${{ number_format($invoice->materials->sum('subtotal'), 2, '.', '') }} materials,
							${{ number_format($invoice->labour->sum('subtotal'), 2, '.', '') }} labour =
							${{ number_format($invoice->materials->sum('subtotal') + $invoice->labour->sum('subtotal'), 2, '.', '') }}
						</small>
					</li>
				@endforeach
				@empty( $unpaid->all() )
					<li class="list-group-item">
						<p class="list-group-item-text">
							Congratulations, no unpaid invoices!
						</p>
					</li>
				@endempty
				</ul>
				@if( $total > 0 )
				<div class="card-footer text-muted">
					<div>
						Total Material: ${{ number_format( $materialTotal, 2, '.', '' ) }}
					</div>
					<div>
						Total Labour: ${{ number_format( $labourTotal, 2, '.', '' ) }}
					</div>
					<div>
						<strong>
							Total: ${{ number_format( $total, 2, '.', '' ) }}
						</strong>
					</div>
				</div><!-- /.card-footer -->
			@endif
			</div><!-- /.card -->
		</div><!-- /.col-md-6 -->
	</div><!-- /.row -->
@endsection
