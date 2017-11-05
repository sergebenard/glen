<!DOCTYPE html>
<html lang="en">
		<head>
			<title>@yield('page-title', config('app.name'))</title>

			<!-- Required meta tags -->
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

			<style type="text/css">
				html, body {
				  height: 100%;
				}
				.page-wrap {
				  min-height: 100%;
				  /* equal to footer height */
				  margin-bottom: 40px; 
				}
				.page-wrap:after {
				  content: "";
				  display: block;
				}
				.site-footer, .page-wrap:after {
				  height: 142px; 
				}

				table {
				    border-collapse: collapse;
				    width: 100%;
				}
				table h1 {
					margin: 0px;
				}
				thead tr {
					background-color: #D1D1D1;
					color: #333;
				}
				thead th, thead td {
					border: all .2pt solid #333;
				}
				th, td {
					padding: 8px;
				}

				.table tbody th, .table tbody td {
				    border: all .2pt solid #333;
				}

				tbody tr:nth-child(even){
					background-color: #F0F0F0;
				}
				table .table-inverse {
					font-weight: bold;
					background: #AAA;
				}
				.table-dark, .table-dark td, .table-dark th {
					color: #333;
					border-top: .2pt solid black;
					border-left: .2pt solid #333;
					border-right: .2pt solid #333;
					border-bottom: .2pt solid #333;
				}
				.table-total, .table-total td, .table-total th {
					font-size: 1.1em;
					color: #333;
					border-top: .5pt double black;
					background-color: #CCC;
					border-left: .2pt solid #333;
					border-right: .2pt solid #333;
					border-bottom: .2pt solid #333;
				}
				.table p {
					margin: 0px;
				}
				.text-right {
					text-align: right;
				}
				.text-muted {
					color: #333;
					font-style: italic;
				}
				.text-address {
					font-size: 1.2em;
					color: #333;
				}
				.m-0 {
					margin: 0px;
				}
				.mb-5 {
					margin-bottom: 2em;
				}
			</style>
		</head>
		<body>
			<div class="container">
				@yield('page-content')
			</div><!-- /.container -->
		</body>
</html>