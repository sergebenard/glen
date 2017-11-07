@extends('layouts.mail')

@section('mail-content')
	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
	<tr>
		<td class="outer-padding" valign="top" align="left">
		<center>
			<table class="w320" cellspacing="0" cellpadding="0" width="600" height="723">
				<tr>

					<td class="col-1 hide-for-mobile">

						<table cellspacing="0" cellpadding="0" width="100%">
							<tr>
								<td class="hide-for-mobile" style="padding:30px 0 10px 0;">
									{{-- <img width="40" height="31" src="https://www.filepicker.io/api/file/GNoaqKTQX6VXtdvaywb1" alt="logo" /> --}}
								</td>
							</tr>

							<tr>
								<td class="hide-for-mobile"  height="150" valign="top" >
									<b>
										<span>{{ env('APP_NAME', 'Glen Lall') }}</span>
										</b>
									<br>
									<span>Gatineau, Quebec</span>
									<br>
									<span>
										<a href="{{ url('/') }}">
											Website
										</a>
									</span>
								</td>
							</tr>

							<tr>
								<td class="hide-for-mobile" style="height:180px; width:299px;">
									{{-- <img width="180" height="299"src="https://www.filepicker.io/api/file/3UaTJxcRScNj3PEVofl4" alt="large logo" /> --}}
								</td>
							</tr>
						</table>
					</td>

					<td valign="top" class="col-2">
						<table cellspacing="0" cellpadding="0" width="100%">
							<tr>
								<td class="body-cell body-cell-left-pad" width="355" height="661" valign="top">
									<table cellpadding="0" cellspacing="0">
										<tr>
											<td width="355">
												<h1>
													Invoice:
													<span>
														{{ $invoice->job->number }}-I
													</span>
												</h1>
												<h2>
													<span>
														{{ date('D, jS \of F Y') }}
													</span>
												</h2>
											</td>
										</tr>
										<tr>
											<td width="355">
												<table class="data-table" cellpadding="0" cellspacing="0">
													<tr>
														<th>
															Client
														</th>
													</tr>
													<tr>
														<td>
															<span>
																{{ $invoice->job->name }}<br>
																{!! nl2br( $invoice->job->address ) !!}
															</span>
														</td>
													</tr>
													<tr>
														<th>
															Materials &amp; Labour
														</th>
													</tr>
													<tr>
														<th>
															Amount Due
														</th>
													</tr>
													<tr>
														<td>
															<table cellpadding="0" cellspacing="0">
																<tr>
																	<td class="data-table-amount" style="width: 85px;">
																		<span>
																			${{ number_format( $invoice->labour->sum('subtotal') + $invoice->materials->sum('subtotal'), 2, '.', '' ) }}
																		</span>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td width="355" class="footer">
												<center>
													<img width="213" height="48" src="{{ asset('/images/email-thank-you.png') }}">
												</center>
											</td>
										</tr>
									</table>

									<table cellspacing="0" cellpadding="0" width="100%">
										<tr>
											<td class="hide-for-desktop-text">
												<b>
													<span>{{ env('APP_NAME', 'Glen Lall') }}</span>
												</b>
												<br>
												<span>Gatineau, Quebec</span>
												<br>
												<a href="{{ url('/') }}">
													Website
												</a>
											</td>
										</tr>
									</table>
								</td>

							</tr>
						</table>
					</td>

				</tr>
			</table>
		</center>
		</td>
	</tr>
	</table>
@stop