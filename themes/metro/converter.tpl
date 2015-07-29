<html>
<head>
<title>{SITENAME}</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="themes/{THEME}/style.css">
<script type="text/javascript" src="{SITEURL}js/jquery.js"></script>
<script type="text/javascript" src="{SITEURL}js/google_converter.js"></script>
</head>
<body>
<div id="content">
	<div class="container">
		<div class="titTable2 rounded-top rounded-bottom">
			{L_085}
		</div>
		<div class="table3">
			<form name="form1" method="post" action="">
            	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<table width="90%" border="0" cellspacing="0" cellpadding="5">
                    <tr class="row">
                        <td class="success-box" id="results" colspan="3" align="center">{CONVERSION}</td>
                    </tr>
                    <tr>
                    	<td align="center">{L_082}</td>
                        <td width="39%">{L_083}</td>
                        <td width="39%">{L_088}</td>
                    </tr>
					<tr valign="top">
						<td align="center">
							<input type="text" name="amount" id="amount" size="5" value="{AMOUNT}">
						</td>
						<td>
							<select name="fromCurrency" id="fromCurrency">
<!-- BEGIN from -->
								<option value="{from.VALUE}"<!-- IF from.B_SELECTED --> selected="true"<!-- ENDIF -->>{from.VALUE} {from.NAME}</option>
<!-- END from -->
							</select>
						</td>
						<td>
							<select name="toCurrency" id="toCurrency">
<!-- BEGIN to -->
								<option value="{to.VALUE}"<!-- IF to.B_SELECTED --> selected="true"<!-- ENDIF -->>{to.VALUE} {to.NAME}</option>
<!-- END to -->
							</select>
						</td>
					</tr>
				</table>
				<div style="text-align:center">
                	<input type="button" name="convert" id="convert" value="{L_25_0176}">
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