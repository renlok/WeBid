<html>
<head>
<title>{SITENAME}</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="themes/{THEME}/style.css">
</head>
<body>
<div id="content">
	<div class="container">
		<div class="titTable2 rounded-top rounded-bottom">
			{L_085}
		</div>
		<div class="table3">
			<form name="form1" method="post" action="">
				<table width="100%" border="0" cellspacing="0" cellpadding="5">
<!-- IF B_CONVERSION -->
					<tr valign="top">
						<th colspan="3">
	<!-- IF ERROR eq '' -->
						{CONVERSION}
	<!-- ELSE -->
						{ERROR}
	<!-- ENDIF -->
						</th>
					</tr>
<!-- ELSE -->
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
<!-- ENDIF -->
					<tr valign="top">
						<td width="22%">{L_082}<br>
							<input type="text" name="amount" size="5" value="{AMOUNT}">
						</td>
						<td width="39%">{L_083}<br>
							<select name="from">
<!-- BEGIN from -->
								<option value="{from.VALUE}"<!-- IF from.B_SELECTED --> selected="true"<!-- ENDIF -->>{from.VALUE} {from.NAME}</option>
<!-- END from -->
							</select>
						</td>
						<td width="39%">{L_088}<br>
							<select name="to">
<!-- BEGIN to -->
								<option value="{to.VALUE}"<!-- IF to.B_SELECTED --> selected="true"<!-- ENDIF -->>{to.VALUE} {to.NAME}</option>
<!-- END to -->
							</select>
						</td>
					</tr>
				</table>
				<div style="text-align:center">
					<input type="hidden" name="action" value="convert">
					<input type="submit" name="Submit" value="{L_25_0176}">
				</div>
			</form>
		</div>
		<div style="text-align:center">
			<input type="button" value="Close" onClick="javascript:window.close()">
		</div>
		<br>
	</div>
</div>
</body>
</html>