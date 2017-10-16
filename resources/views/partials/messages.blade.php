	@if( session('message'))
		<!-- Passed On Message -->
		<div class="container">
			<div class="alert alert-info" role="alert">
				<span class="fa fa-info-circle" aria-hidden="true"></span>
				<span class="sr-only">Message:</span>
				{{ session('message') }}
			</div>
		</div>
	@endif
	@if( session('success'))
		<div class="container">
			<div class="alert alert-success" role="alert">
				<span class="fa fa-check-circle" aria-hidden="true"></span>
				<span class="sr-only">Success:</span>
				{{ session('success') }}
			</div>
		</div>
	@endif
	@if( session('error'))
		<!-- Passed On Error -->
		<div class="container">
			<div class="alert alert-danger" role="alert">
				<span class="fa fa-exclamation-circle" aria-hidden="true"></span>
				<span class="sr-only">Error:</span>
				{{ session('error') }}
			</div>
		</div>
	@endif
	@if( isset( $errors) && count( $errors ) )
		<!-- Form Errors -->
		<div class="container">
			<div class="alert alert-danger" role="alert">
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

	