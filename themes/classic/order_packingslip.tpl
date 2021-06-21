<!DOCTYPE html>
<html dir="{DOCDIR}" lang="{LANGUAGE}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={CHARSET}">

<title>{L_1033}</title>

<style type="text/css">
	.pageHeading { font-family: Verdana, Arial, sans-serif; font-size: 18px; color: #727272; font-weight: bold; }
	.pageHeading-invoice { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; font-weight: normal; padding: 3px; }
	.main { font-family: Verdana, Arial, sans-serif; font-size: 12px; }
	.main-payment { font-family: Verdana, Arial, sans-serif; font-size: 12px; background-color: #F0F1F1; border: 1px ridge #000000; }
	.dataTableHeadingRow { background-color: #C9C9C9; }
	.dataTableHeadingContent-invoice { font-family: Verdana, Arial, sans-serif;	font-size: 10px; color: #000000; font-weight: bold; border: 1px ridge #000000;}
	.dataTableRow { background-color: #F0F1F1; }
	.dataTableContent { font-family: Verdana, Arial, sans-serif; font-size: 10px; color: #000000; }
	.smallText { font-family: Verdana, Arial, sans-serif; font-size: 10px; }
	.main-payment2 { font-family: Verdana, Arial, sans-serif; font-size: 12px; background-color: #FFFF99; border: 1px ridge #000000; }
</style>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#ffffff" marginheight="0" marginwidth="0">
<!-- IF B_INVOICE -->

<table width="830px" border="0">
	<tbody>
		<tr>
			<td>
				<table width="100%" border="0">
					<tbody>
						<tr>
							<td width="350">
								<table width="100%" border="0" cellpadding="0" cellspacing="0" height="100%">
									<tbody>
										<tr>
											<td valign="top" align="center"><img src="{LOGO}" alt="" border="0"></td>
										</tr>
										<tr>
											<td class="pageHeading-invoice" valign="top" align="left">
												<b>Seller:</b> {SENDER}
											</td>
										</tr>
									</tbody>
								</table>
							</td>
							<td>&nbsp;</td>
							<td valign="top" width="350" align="right"></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td><hr></td>
							<td class="pageHeading" valign="middle" width="120" align="center"><em><b>{L_1033}</b></em></td>
							<td width="10%"><hr></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%" border="0">
					<tbody>
						<tr>
							<td valign="top" width="350" align="left">
								<table class="main" width="100%" border="0" cellpadding="0" cellspacing="0">
									<tbody>
										<tr>
											<td valign="top" align="left"><b>{L_1037}</b></td>
										</tr>
										<tr>
											<td valign="bottom" align="left">&nbsp;</td>
										</tr>
										<tr>
											<td>{WINNER_NICK}<br>{WINNER_ADDRESS}</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
									</tbody>
								</table>
							</td>
							<td>&nbsp;</td>
							<td valign="top" width="350" align="right">
								<table class="main" width="100%" border="0" cellpadding="0" cellspacing="0">
									<tbody>
										<tr>
											<td valign="top" align="left"><b>{L_1038}</b></td>
										</tr>
										<tr>
											<td valign="bottom" align="left">&nbsp;</td>
										</tr>
										<tr>
											<td valign="bottom" align="left">{WINNER_NICK}<br>{WINNER_ADDRESS}</td>
										</tr>
										<tr>
											<td valign="bottom" align="left">&nbsp;</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%" border="0" cellpadding="2" cellspacing="0">
					<tbody>
						<tr>
							<td class="main-payment"><b>{L_1034}</b><br>{AUCTION_ID}</td>
							<td class="main-payment"><b>{L_1036}</b><br>{CLOSING_DATE}</td>
							<td class="main-payment"><b>{L_1055}</b><br>{PAYMENT_METHOD}</td>
							<td class="main-payment"><b>{L_1054}</b><br>{SHIPPING_METHOD}</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<table width="100%" border="0" cellpadding="2" cellspacing="0">
					<tbody>
						<tr class="dataTableHeadingRow">
							<td class="dataTableHeadingContent-invoice">{L_1044}</td>
						</tr>
						<tr class="dataTableRow">
							<td class="dataTableContent" valign="top">
								{ITEM_QUANTITY} x {AUCTION_TITLE}
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>

<!-- ELSE -->
<div style="position: absolute; top: 15%; left: 40%;">
	<h4>{L_1056}</h4>
</div>
<!-- ENDIF -->

<div style="position: absolute; right: 20%; margin-top:15px;">
	<form><input id="printpagebutton" type="button" value="{L_1060a}" onclick="printpage()"/></form>
</div>


<script type="text/javascript">
	function printpage() {
		var printButton = document.getElementById("printpagebutton");
		printButton.style.visibility = 'hidden';
		window.print();
		printButton.style.visibility = 'visible';
	}
</script>

</body>
</html>