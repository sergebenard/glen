		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavDropdown">
			@auth
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="{{ url('/home') }}">
						Admin
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ url('/jobs') }}">
						Jobs
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ url('/calculator') }}">
						Calculator
						</a>
					</li>

				</ul>
				@endauth
				<ul class="navbar-nav ml-auto">
					@if (Auth::guest())
					<li class="nav-item">
						<a class="nav-link" href="{{ url('/login') }}">
							Log In
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ url('/register') }}">
							Register
						</a>
					</li>
					@else
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							{{ Auth::user()->name }}
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<li class="dropdown-item">
								<a class="nav-link" href="{{ route('preferences.show', 1) }}">
									Site Preferences
								</a>
							</li>
							<li class="dropdown-item">
								<a class="nav-link" href="{{ url('/logout') }}"
								 onclick="event.preventDefault();
										 document.getElementById('logout-form').submit();">
								Logout
								</a>
							</li>
						</ul>
					</li>
					@endif
				</ul>
			</div>
			<form id="logout-form" action="{{ url('/logout') }}" method="POST"
				style="display: none;">
			{{ csrf_field() }}
			</form>
		</nav>