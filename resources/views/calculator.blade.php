@extends('layouts.admin')

@section('page-title', 'Soffit Calculator')

@section('page-content')

<div class="card-deck">
	<div class="card">
		<div class="card-block">
			<p class="card-text">Calculate the Soffit Details.</p>
			
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
		</div>
	</div>
</div>
@endsection


@section('page-script')
<script>
$('#soffitLinearFeet').on('change keyup paste', function() {
	updateSoffit();
});

$('#soffitDepth').on('change keyup paste', function() {
	updateSoffit();
});

function updateSoffit()
{
	var linearFeet = $('#soffitLinearFeet');
	var soffitDepth = $('#soffitDepth');

	var	r = 0,
		soffitPieces = 0,
		soffitSheets = 0,
		soffitPiecesPerSheet = 0;

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

</script>
@endsection