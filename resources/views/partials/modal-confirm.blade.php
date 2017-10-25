	<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="confirmModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p class="lead">Are you sure you want to do this?</p>
					<p class="text-info">
						<i class="fa fa-exclamation-circle"></i>
						All items attached to this may be affected, and this action may not be reversible.
					</p>
				</div>
				<div class="modal-footer">
					<button 	type="button" 
								id="btnModalConfirm" 
								class="btn btn-primary">
						Yes
					</button>
					<button 	type="button"
								class="btn btn-outline-primary"
								data-dismiss="modal">
						Close
					</button>
				</div>
			</div>
		</div>
	</div>

	<script>
		var titleText = null;
		var defaultTitleText = "Action Performed";
		var formID = null;

		$('#confirmModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget); // Button that triggered the modal
			titleText = button.data('titletext'); // Extract info from data-* attributes
			formID = button.data('formid');
			// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
			// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

			if ( checkValues() === false )
			{
				modal.find('.modal-body').text(`
					<p class="text-exclamation-triangle">
						<i class="fa fa-exclamation-triangle"></i>
						Cannot perform desired action.
					</p>
					`);
			}

			/*console.log(	'titleText: ' + titleText,
							'defaultTitleText: ' + defaultTitleText,
							'formID: ' + formID);*/

			var modal = $(this);
			modal.find('.modal-title').text( titleText );
			
			$('#btnModalConfirm').click( function() {
				$('#' + formID).submit();
			});
		});

		function checkValues()
		{
			if ( formID === null )
			{
				return false;
			}
			else if( titleText === null )
			{
				titleText = defaultTitleText;
			}

			return true;
		}
	</script>