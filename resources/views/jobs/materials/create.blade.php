@extends('layouts.admin')

@section('page-title', 'Add Material')

@section('page-breadcrumbs')
	<ol class="breadcrumb my-2">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Admin Home</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Jobs</a></li>
		<li class="breadcrumb-item"><a href="{{ route('jobs.show', $job->id) }}">{{ $job->number }}</a></li>
		<li class="breadcrumb-item active">New Material</li>
	</ol>
@endsection

@section('page-content')
	<div id="accordion" role="tablist" class="mb-2">
		<div class="card">
			<div class="card-header" role="tab" id="headingOne">
				<h5 class="mb-0">
					<a data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
						Soffit Calculator
					</a>
				</h5>
			</div>

			<div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
				<div class="card-body">
					<div class="form-group">
						<label for="soffitLinearFeet">Linear Feet</label>
						<input type="number" class="form-control" id="soffitLinearFeet" aria-describedby="soffitLinearFeetHelp" placeholder="Feet" min="1" max="1000" maxlength="3">
						<small id="soffitLinearFeetHelp" class="form-text text-muted">Enter how many linear feet of soffit coverage you're estimating for your project.</small>
					</div>
					<div class="form-group">
						<label for="soffitDepth">Soffit Depth</label>
						<input type="number" class="form-control" id="soffitDepth" aria-describedby="soffitDepthHelp" placeholder="Inches" min="1" max="144" maxlength="3">
						<small id="soffitDepthHelp" class="form-text text-muted">Enter how many inches you're estimating for the depth of the soffit.</small>
					</div>
				</div>
				<div class="card-footer">
					<div class="card-text">
						Pieces: 
						<span id="soffitPiecesResult">
							0
						</span>
					</div>
					<div class="card-text">
						Sheets: 
						<span id="soffitSheetsResult">
							0
						</span>
					</div>
					<div class="card-text">
						Pieces per Sheet:
						<span id="soffitPiecesPerSheetResult">
							0
						</span>
					</div>
					<button 	id="calculatorCopy"
								type="button"
								class="btn btn-outline-primary">
						Copy to Materials
					</button>
				</div>
			</div>
		</div>
	</div>
	<form 	action="{{ route('jobs.materials.store', $job->id) }}"
			method="POST"
			enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="form-group">
			<label 	for="materialAmount" 
					{{ $errors->has('count') ? 'text-danger' :'' }}>
				Item Count
			</label>
			<input 	type="number"
					name="count"
					class="form-control {{ $errors->has('count') ? 'is-invalid' :'' }}"
					id="materialAmount"
					value="{{ old('count', '1') }}"
					step="any"
					autocomplete="off"
					min="1"
					required>
			<small class="form-text {{ $errors->has('count') ? 'invalid-feedback' :'' }}">
				Required.
			</small>
		</div>
		<div class="form-group">
			<label 	for="materialName" 
					{{ $errors->has('name') ? 'text-danger' :'' }}>
				Item Name
			</label>
			<input 	type="text"
					name="name"
					class="form-control {{ $errors->has('name') ? 'is-invalid' :'' }}"
					id="materialName"
					value="{{ old('name') }}"
					autocomplete="off"
					placeholder="Ex: Roll Flatstock or Box Screws" 
					required>
			<small class="form-text {{ $errors->has('name') ? 'invalid-feedback' :'' }}">
				Required.
			</small>
		</div>
		<div class="form-group">
			<label 	for="materialDescription" 
					{{ $errors->has('description') ? 'text-danger' :'' }}>
				Item Description
			</label>
			<input 	type="text"
					name="description"
					class="form-control {{ $errors->has('description') ? 'is-invalid' :'' }}"
					id="materialDescription"
					value="{{ old('description') }}"
					autocomplete="off"
					placeholder="Ex: White or Brown or Construction">
			<small class="form-text {{ $errors->has('description') ? 'invalid-feedback' :'' }}">
				Optional.
			</small>
		</div>
		<div class="form-group">
			<label 	for="materialName" 
					{{ $errors->has('cost') ? 'text-danger' :'' }}>
				Item Cost
			</label>
			<div class="input-group">
				<div class="input-group-addon {{ $errors->has('cost') ? 'bg-danger text-white' :'' }}">$</div>
				<input 	type="number"
						name="cost"
						class="form-control {{ $errors->has('cost') ? 'is-invalid' :'' }}"
						id="materialName"
						value="{{ old('cost') }}"
						autocomplete="off"
						step="any"
						placeholder="Ex: 15.00">
			</div><!-- /input-group -->
			<div class="clearfix">
			</div>
			<small class="form-text {{ $errors->has('cost') ? 'invalid-feedback' :'' }}">
				Optional.
			</small>
		</div>

		<button class="btn btn-primary" type="submit">Save New</button>
		<a class="btn btn-outline-primary" href="{{ route('jobs.show', $job->id) }}">
			Cancel
		</a>
	</form>
@stop

@section('page-script')
<script>

$('#soffitLinearFeet').on('change keyup paste', function() {
	updateSoffit();
});

$('#soffitDepth').on('change keyup paste', function() {
	updateSoffit();
});

var	r = 0,
	soffitPieces = 0,
	soffitSheets = 0,
	soffitPiecesPerSheet = 0;

function updateSoffit()
{
	var linearFeet = $('#soffitLinearFeet');
	var soffitDepth = $('#soffitDepth');

	// Check to see if two fields have numbers
	if ( 	$.isNumeric( linearFeet.val() ) &&
			$.isNumeric( soffitDepth.val() ) &&
			linearFeet.val() > 0 &&
			soffitDepth.val() > 0 )
	{

		soffitPieces = 0;
		soffitSheets = 0;
		soffitPiecesPerSheet = 0;

		soffitPieces = Math.round( linearFeet.val() * 12 / 16 * 100 ) / 100;

		soffitPiecesPerSheet = Math.round( 144 / soffitDepth.val() * 100 ) / 100;

		soffitSheets = Math.round( soffitPieces / soffitPiecesPerSheet * 100 ) / 100;

		// alert( 'Linear Feet: ' + linearFeet.val() + '; \n' +
		// 		'Soffit Depth: ' + soffitDepth.val() + '\n' +
		// 		'Soffit Pieces: ' + soffitPieces  + '\n' +
		// 		'Soffit Pieces per Sheet: ' + soffitPiecesPerSheet  + '\n' +
		// 		'Soffit Sheets: ' + soffitSheets
		// 		 );

		soffitSetResults(	soffitPieces,
							soffitPiecesPerSheet,
							soffitSheets );
	}
}

function soffitSetResults( pieces, piecesPerSheet, soffitSheets )
{
	$('#soffitPiecesResult').text(	Math.ceil( pieces ) +
									' (' + pieces + ')' );

	$('#soffitSheetsResult').text(	Math.ceil( soffitSheets ) +
									' (' + soffitSheets + ')' );

	$('#soffitPiecesPerSheetResult').text(	Math.floor( piecesPerSheet ) +
											' (' + piecesPerSheet + ')' );
}

$('#calculatorCopy').click(function(){

	$('.collapse').collapse('hide');

	$('#materialAmount').val( Math.ceil( soffitSheets ) );
	$('#materialName').val('Soffit Sheets');
});
</script>
@stop