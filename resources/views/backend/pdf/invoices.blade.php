<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
	body {
		font-family: DejaVu Sans, sans-serif;
		font-size: 10px;
		padding: 0 5px;
	}

	p {
		margin: 2px 0;
	}

	html,
	body {
		height: 297mm;
		width: 207mm;
		margin: 0px;
	}

	.sqr {
		display: inline-block;
		border: 1px solid black;
		width: 12px;
		height: 12px;
		background-color: white;
		position: relative;
	}

	table {
		border-collapse: collapse;
	}

	table thead tr th,
	table tbody tr th {
		background: #12469a;
		color: #fff;
		text-transform: uppercase;
		padding: 0;
		border: 2px solid #12469a;
		vertical-align: baseline;
	}

	table thead tr th div,
	table tbody tr th div {
		padding: 5px;
	}

	table thead tr td,
	table tbody tr td {
		padding: 0;
		border: 2px solid #12469a;
		vertical-align: baseline;
	}

	table thead tr td div,
	table tbody tr td div {
		padding: 5px;
	}

	.row {
		padding: 0;
	}

	.row div {
		padding: 5px;
		display: inline-block;
	}

	.white {
		color: white;
		border-top: 2px solid transparent;
	}

	.whiteB {
		border-bottom: 2px solid transparent;
	}

	img {
		width: 300px;
	}

	.code,
	.logo {
		margin: 30px 0;
	}

	.logo {
		float: left;
	}

	.code {
		float: right;
	}

	.clearfix {
		clear: both;
	}
</style>

<body>

	<div>
		<div>
			<div class='logo'>
				<img src="./logo2.jpg" alt="">
			</div>
			<div class='code'>
				<div>
					<div>
						@php
						$hwb = str_pad($invoices->invoice_number, 6, "0", STR_PAD_LEFT);
						echo $hwb;
						@endphp
					</div>
					<div>
						{!! DNS1D::getBarcodeHTML( $hwb, 'C128') !!}
					</div>
				</div>
			</div>
		</div>
		<div class='clearfix'>
			<table>
				<thead>
					<tr>
						<th colspan='6'>
							<div>FORM(SHIPPER)</div>
						</th>
						<th colspan='6'>
							<div>TO(CONSIGNEE)</div>
						</th>
					</tr>
					<tr>
						<td colspan='6'>
							<div class='row'>
								<div>
									<p>NAME</p>
									<p>312</p>
								</div>
								<div>
									<p>TELEPHONE</p>
									<p>312</p>
								</div>
							</div>
						</td>
						<td colspan='6'>
							<div class='row'>
								<div>
									<p>NAME</p>
									<p>123</p>
								</div>
								<div>
									<p>TELEPHONE</p>
									<p>312</p>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan='6'>
							<div>
								<p>COMPANY</p>
								<p>312</p>
							</div>
						</td>
						<td colspan='6'>
							<div>
								<p>COMPANY</p>
								<p>312</p>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan='6'>
							<div>
								<p>ADDRESS</p>
								<p>312</p>
							</div>
						</td>
						<td colspan='6'>
							<div>
								<p>ADDRESS</p>
								<p>312</p>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan='6'>
							<div class='row'>
								<div>
									<p>CITY</p>
									<p>312312</p>
								</div>
								<div>
									<p>STATE/COUNTRY</p>
									<p>312</p>
								</div>
								<div>
									<p>POSTCODE</p>
									<p>312</p>
								</div>
							</div>
						</td>
						<td colspan='6'>
							<div class='row'>
								<div>
									<p>CITY</p>
									<p>312312</p>
								</div>
								<div>
									<p>STATE/COUNTRY</p>
									<p>312312312</p>
								</div>
								<div>
									<p>POSTCODE</p>
									<p>312312312</p>
								</div>
							</div>
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th colspan='12'>
							<div>SHIPMENT INFORMATION</div>
						</th>
					</tr>
					<tr>
						<td colspan='6' rowspan='2'>
							<div>
								<p>FULL DESCRIPTION OF CONTENTS</p>
								<p>42342</p>
							</div>
						</td>
						<td>
							<div>№</div>
						</td>
						<td>
							<div>Type</div>
						</td>
						<td>
							<div>Dimensions</div>
						</td>
						<td>
							<div>Serial Number Box</div>
						</td>
						<td>
							<div>Serial Number Sensor</div>
						</td>
						<td>
							<div>Temperature(TT)</div>
						</td>
					</tr>
					<tr>
						<td>
							<div>1</div>
						</td>
						<td>
							<div>terter</div>
						</td>
						<td>
							<div>1x1x1</div>
						</td>
						<td>
							<div></div>
						</td>
						<td>
							<div></div>
						</td>
						<td>
							<div>1</div>
						</td>
					</tr>
					<tr>
						<td colspan='2'>
							<div>
								<p>#OF PCS QUANTITY</p>
								<p>1</p>
							</div>
						</td>
						<td colspan='4'>
							<div>
								<p>WEIGHT 1 KGS</p>
								<p>CHARGEABLE WEIGHT 0 KGS</p>
							</div>
						</td>
						<td colspan='6'>
							<div>
								<p>DOES THIS SHIPMENT CONTAIN DANGEROUS GOODS?</p>
								<p>
									<span class='sqr'></span> NO <span class='sqr'></span> YES
								</p>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan='12'>
							<div>
								AIR EXPRESS LIABILITY IS LIMITED
							</div>
						</td>
					</tr>
					<tr>
						<td colspan='12'>
							<div>
								SHIPPER'S SECURITY ENDORSEMENT: I CERTIFY THAT THIS CARGO DOES NOT CONTAIN ANY
								UNANTHORIZED
								EXPLOSILVER,
								INCENDIARIES, OR HAZARDOUS MATELRIALS. I CONSENT OF THIS CARGO, I AM AWARE THAT THIS
								ENDORSEMENT AND
								ORIGINAL SIGNATURE, ALONG WITH OTHER SHIPPING DOCUMENTS, WILL BE RETAINED ON FILE FOR AT
								LEAST
								THIRTY
								DAYS.
							</div>
						</td>
					</tr>
					<tr>
						<td class='whiteB' colspan='5'>
							<div>
								<P>PRINT NAME OF SHIPPER OR SHIPPER'S AGENT:</P>
								<P></P>
							</div>
						</td>
						<td class='whiteB'>
							<div>
								<p>DATE: <span>21:31:3124</span></p>
							</div>
						</td>
						<td class='whiteB' colspan='5'>
							<div>
								<P>PRINT NAME OF CONSIGNEE OR CONSIGNEE'S AGENT:</P>
								<P></P>
							</div>
						</td>
						<td class='whiteB'>
							<div>
								<p>DATE: <span>21:31:3124</span></p>
							</div>
						</td>
					</tr>
					<tr>
						<td class='white' colspan='5'>
							<div class='white'>
								<p>SIGNATURE OF SHIPPER OR SHIPPER'S AGENT:</p>
								<p></p>
							</div>
						</td>
						<td class='white'>
							<div class='white'>
								<p>TIME: <span></span></p>
							</div>
						</td>
						<td class='white' colspan='5'>
							<div class='white'>
								<p>SIGNATURE OF CONSIGNEE OR CONSIGNEE'S AGENT:</p>
								<p></p>
							</div>
						</td>
						<td class='white'>
							<div class='white'>
								<p>TIME: <span>21:31</span></p>
							</div>
						</td>
					</tr>
					<tr>
						<td class='whiteB' colspan='5'>
							<div>
								<p>SIGNATURE OF SHIPPER OR SHIPPER'S AGENT:</p>
								<p></p>
							</div>
						</td>
						<td class='whiteB'>
							<div>
								<p>TIME: <span></span></p>
							</div>
						</td>
						<td class='whiteB' colspan='5'>
							<div>
								<p>SIGNATURE OF CONSIGNEE OR CONSIGNEE'S AGENT:</p>
								<p></p>
							</div>
						</td>
						<td class='whiteB'>
							<div>
								<p>TIME: <span>21:31</span></p>
							</div>
						</td>
					</tr>
					<tr>
						<td class='white' colspan='5'>
							<div class='white'>
								<p>SIGNATURE OF SHIPPER OR SHIPPER'S AGENT:</p>
								<p></p>
							</div>
						</td>
						<td class='white'>
							<div class='white'>
								<p>TIME: <span></span></p>
							</div>
						</td>
						<td class='white' colspan='5'>
							<div class='white'>
								<p>SIGNATURE OF CONSIGNEE OR CONSIGNEE'S AGENT:</p>
								<p></p>
							</div>
						</td>
						<td class='white'>
							<div class='white'>
								<p>TIME: <span></span></p>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</body>

</html>
