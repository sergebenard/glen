<!DOCTYPE html>
<html lang="en">
		<head>
				<title>@yield('page-title', config('app.name'))</title>

				<!-- Required meta tags -->
				<meta charset="utf-8">
				<meta name="viewport" content="width=612, shrink-to-fit=no, initial-scale=1, maximum-scale=1, minimum-scale=1">

				<!-- Bootstrap CSS -->
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

				<style type="text/css">
						body {
							background: rgb(204,204,204); 
						}
						page {
							background: white;
							display: block;
							margin: 1cm auto;
							padding: 1cm;
							margin-bottom: 0.5cm;
							box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
						}
						page[size="A4"] {  
							width: 21cm;
							height: 29.7cm; 
						}
				</style>
		</head>
		<body>
				<div class="container">
						@yield('page-controls')
						<page size="A4" class="d-print-none">
								@yield('page-content')
						</page>
				</div><!-- /.container -->

				<!-- jQuery first, then Popper, then Bootstrap JS. -->
				<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
		</body>
</html>