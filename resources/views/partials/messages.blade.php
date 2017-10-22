	@if( session('message'))
		<!-- Passed On Message -->
		<div class="container fixed-top">
			<div class="alert alert-info" role="alert">
				<span class="fa fa-info-circle" aria-hidden="true"></span>
				<span class="sr-only">Message:</span>
				{{ session('message') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
	@endif
	@if( session('success'))
		<div class="container fixed-top">
			<div class="alert alert-success" role="alert">
				<span class="fa fa-check-circle" aria-hidden="true"></span>
				<span class="sr-only">Success:</span>
				{{ session('success') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
	@endif
	@if( session('error'))
		<!-- Passed On Error -->
		<div class="container fixed-top">
			<div class="alert alert-danger" role="alert">
				<span class="fa fa-exclamation-circle" aria-hidden="true"></span>
				<span class="sr-only">Error:</span>
				{{ session('error') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
	@endif
	@if( isset( $errors) && count( $errors ) )
		<!-- Form Errors -->
		<div class="container fixed-top">
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h2 class="alert-heading">
					<span class="fa fa-exclamation-circle" aria-hidden="true"></span>
					Error!
				</h2>
				<p>
					Please fix these errors:
				</p>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		</div>
	@endif

	