<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=320, initial-scale=1" />
	<title>Cleave Invoice</title>
	<style type="text/css" media="screen">

		/* ----- Client Fixes ----- */

		/* Force Outlook to provide a "view in browser" message */
		#outlook a {
			padding: 0;
		}

		/* Force Hotmail to display emails at full width */
		.ReadMsgBody {
			width: 100%;
		}

		.ExternalClass {
			width: 100%;
		}

		/* Force Hotmail to display normal line spacing */
		.ExternalClass,
		.ExternalClass p,
		.ExternalClass span,
		.ExternalClass font,
		.ExternalClass td,
		.ExternalClass div {
			line-height: 100%;
		}


		 /* Prevent WebKit and Windows mobile changing default text sizes */
		body, table, td, p, a, li, blockquote {
			-webkit-text-size-adjust: 100%;
			-ms-text-size-adjust: 100%;
		}

		/* Remove spacing between tables in Outlook 2007 and up */
		table, td {
			mso-table-lspace: 0pt;
			mso-table-rspace: 0pt;
		}

		/* Allow smoother rendering of resized image in Internet Explorer */
		img {
			-ms-interpolation-mode: bicubic;
		}

		 /* ----- Reset ----- */

		html,
		body,
		.body-wrap,
		.body-wrap-cell {
			margin: 0;
			padding: 0;
			background: #ffffff;
			font-family: Arial, Helvetica, sans-serif;
			font-size: 16px;
			color: #89898D;
			text-align: left;
		}

		img {
			border: 0;
			line-height: 100%;
			outline: none;
			text-decoration: none;
		}

		table {
			border-collapse: collapse !important;
		}

		td, th {
			text-align: left;
			font-family: Arial, Helvetica, sans-serif;
			font-size: 16px;
			color: #89898D;
			line-height:1.5em;
		}

		/* ----- General ----- */

		h1, h2 {
			line-height: 1.1;
			text-align: right;
		}

		h1 {
			margin-top: 0;
			margin-bottom: 10px;
			font-size: 24px;
		}

		h2 {
			margin-top: 0;
			margin-bottom: 60px;
			font-weight: normal;
			font-size: 17px;
		}

		.outer-padding {
			padding: 50px 0;
		}

		.col-1 {
			border-right: 1px solid #D9DADA;
			width: 180px;
		}

		td.hide-for-desktop-text {
			font-size: 0;
			height: 0;
			display: none;
			color: #ffffff;
		}

		img.hide-for-desktop-image {
			font-size: 0 !important;
			line-height: 0 !important;
			width: 0 !important;
			height: 0 !important;
			display: none !important;
		}

		.body-cell {
			background-color: #ffffff;
			padding-top: 60px;
			vertical-align: top;
		}

		.body-cell-left-pad {
			padding-left: 30px;
			padding-right: 14px;
		}

		/* ----- Modules ----- */

		.brand td {
			padding-top: 25px;
		}

		.brand a {
			font-size: 16px;
			line-height: 59px;
			font-weight: bold;
		}

		.data-table th,
		.data-table td {
			width: 350px;
			padding-top: 5px;
			padding-bottom: 5px;
			padding-left: 5px;
		}

		.data-table th {
			background-color: #f9f9f9;
			color: #f8931e;
		}

		.data-table td {
			padding-bottom: 30px;
		}

		.data-table .data-table-amount {
			font-weight: bold;
			font-size: 20px;
		}


	</style>

	<style type="text/css" media="only screen and (max-width: 650px)">
		@media only screen and (max-width: 650px) {
			table[class*="w320"] {
				width: 320px !important;
			}

			td[class*="col-1"] {
				border: none;
			}

			td[class*="hide-for-mobile"] {
				font-size: 0 !important; line-height: 0 !important; width: 0 !important;
				height: 0 !important; display: none !important;
			}

			img[class*="hide-for-desktop-image"]{
				width: 176px !important;
				height: 135px !important;
				display:block !important;
				padding-left: 60px;
			}

			td[class*="hide-for-desktop-image"] {
				width: 100% !important;
				display: block !important;
				text-align: right !important;
			}

			td[class*="hide-for-desktop-text"] {
				display: block !important;
				text-align: center !important;
				font-size: 16px !important;
				height: 61px !important;
				padding-top: 30px !important;
				padding-bottom: 20px !important;
				color: #89898D !important;
			}

			td[class*="mobile-padding"] {
				padding-top: 15px;
			}

			td[class*="outer-padding"] {
				padding: 0 !important;
			}

			td[class*="body-cell-left-pad"] {
				padding-left: 20px;
				padding-right: 20px;
			}
		}

	</style>
</head>

<body class="body" style="padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none" bgcolor="#ffffff">
	@yield('mail-content')
</body>
</html>