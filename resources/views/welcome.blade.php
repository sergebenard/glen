@extends('layouts.app')

@section('pageTitle', 'Glen\'s Tools')

@section('content')

<div class="card-deck">
	<div class="card">
		<div class="card-block">
			<h4 class="card-title">Soffit Calculator</h4>
			<p class="card-text">Calculate the Soffit Details.</p>
			
			<div class="form-group">
				<label for="soffitLinearFeet">Linear Feet</label>
				<input type="number" class="form-control" id="soffitLinearFeet" aria-describedby="soffitLinearFeetHelp" placeholder="Feet">
				<small id="soffitLinearFeetHelp" class="form-text text-muted">Enter how many linear feet you're estimating for your project.</small>
			</div>
			<div class="form-group">
				<label for="soffitDepth">Soffit Depth</label>
				<input type="number" class="form-control" id="soffitDepth" aria-describedby="soffitDepthHelp" placeholder="Inches">
				<small id="soffitDepthHelp" class="form-text text-muted">Enter how many inches you're estimating for your project.</small>
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
	<div class="card">
		<div class="card-block">
			<h4 class="card-title">Card title</h4>
			<p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
			<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
		</div>
	</div>
</div>

@endsection


@section('pageScript')
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
	$('#soffitPiecesResult').text(	Math.floor( pieces ) +
									' (' + pieces + ')' );

	$('#soffitSheetsResult').text(	Math.ceil( piecesPerSheet ) +
									' (' + piecesPerSheet + ')' );
	$('#soffitPiecesPerSheetResult').text(	Math.floor( soffitSheets ) +
											' (' + soffitSheets + ')' );
}

</script>
@endsection