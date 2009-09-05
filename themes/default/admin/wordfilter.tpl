<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr> 
	<td background="images/bac_barint.gif">
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
			<tr> 
				<td width="30"><img src="images/i_too.gif"></td>
				<td class="white">{L_5436}&nbsp;&gt;&gt;&nbsp;{L_5068}</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center" valign="middle">
		<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
		<tr>
			<td align="center" class="title">{L_5068}</td>
		</tr>
		<tr>
			<td>
				<form name="conf" action="" method="post">
				<table width="100%" cellpadding="2" align="center" bgcolor="#FFFFFF">
<!-- IF ERROR ne '' -->
				<tr bgcolor="yellow">
					<td class="error" colspan="2" align="center">{ERROR}</td>
				</tr>
<!-- ENDIF -->
				<tr valign="top">
					<td width="109">&nbsp;</td>
					<td width="375">{L_5069}</td>
				</tr>
				<tr valign="top">
					<td height="22">{L_5070}</td>
					<td height="22">
						<input type="radio" name="wordsfilter" value="y"{WFYES}> {L_030}
						<input type="radio" name="wordsfilter" value="n"{WFNO}> {L_029}
					</td>
				</tr>
				<tr valign="top">
					<td height="22">{L_5071}</td>
					<td height="22">
						{L_5072}<br>
						<textarea name="filtervalues" cols="45" rows="15">{WORDLIST}</textarea>
					</td>
				</tr>
				<tr valign="top">
					<td height="22">&nbsp;</td>
					<td height="22">&nbsp;</td>
				</tr>
				<tr>
					<td><input type="hidden" name="action" value="update"></td>
					<td><input type="submit" name="act" value="{L_530}"></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				</table>
				</form>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<!-- INCLUDE footer.tpl -->