@extends('layouts.admin')

@section('page-title', 'Site Preferences')

@section('page-breadcrumbs')
	<ol class="breadcrumb my-2">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Admin Home</a></li>
		<li class="breadcrumb-item active">Site Preferences</li>
	</ol>
@endsection

@section('page-content')
	<div class="card">
		<div class="card-header">
			<p class="card-title mb-0">These settings allow the site to run smoothly.</p>
		</div>
		<ul class="list-group">
			<li class="list-group-item"><strong>Email:</strong> {{ $preference->email ? $preference->email : 'N/A' }}</li>
			<li class="list-group-item">
				<table>
					<tr>
						<td valign="top">
							<strong class="pull-left">Address:</strong>
						</td>
						<td>
							{!! $preference->address ? nl2br( $preference->address ) : 'N/A' !!}
						</td>
					</tr>
				</table>
			</li>
			<li class="list-group-item"><strong>Phone:</strong> {{ $preference->phone ? $preference->formatPhoneNumber( $preference->phone ) : 'N/A' }}</li>
			<li class="list-group-item"><strong>Markup:</strong> {{ $preference->markup ? $preference->markup . '%' : 'N/A' }}</li>
		</ul>
		<div class="card-footer">
			<a href="{{ route('preferences.edit', 1) }}" class="btn btn-primary btn-block">
				Edit
			</a>
		</div>
	</div>
@stop