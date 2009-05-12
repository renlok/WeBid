<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td background="images/bac_barint.gif">
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
			<tr> 
				<td width="30"><img src="images/i_auc.gif" ></td>
				<td class="white">{L_239}&nbsp;&gt;&gt;&nbsp;{L_512}</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="center" valign="middle">&nbsp;</td>
</tr>
<tr>
	<td align="center" valign="middle">
		<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7" align="center">
		<tr>
			<td align="center" class="title">{L_512}</td>
		</tr>
		<tr>
			<td>
				<form name="details" action="" method="post">
				<table width="100%" border="0" cellpadding="5" bgcolor="#FFFFFF">
<!-- IF ERROR ne '' -->
				<tr bgcolor="yellow">
					<td>&nbsp;</td>
					<td class="error" width="486">{ERROR}</td>
				</tr>
<!-- ENDIF -->
				<tr>
					<td width="204" valign="top" align="right">{L_313}</td>
					<td width="486">{USER}</td>
				</tr>
				<tr>
					<td width="204" valign="top" align="right">{L_312}</td>
					<td width="486"><input type="text" name="title" size=40 maxlength=255 value="{TITLE}"></td>
				</tr>
				<tr>
					<td width="204" valign="top" align="right">{L_314}</td>
					<td width="486"><input type="text" name="date" size=20 maxlength=20 value="{STARTS}"></td>
				</tr>
				<tr>
				<td width="204" valign="top" align="right">{L_315}</td>
					<td width="486">
						<select name="duration">
							<option value=""> </option>
							{DURLIST}
						</select>
					</td>
				</tr>
				<tr>
					<td width="204"  valign="top" align="right">{L_316}</td>
					<td width="486">{CATLIST}</td>
				</tr>
				<tr>
					<td width="204" valign="top" align="right">{L_317}</td>
					<td width="486"><textarea name="description" cols="40" rows="8">{DESC}</textarea>
				</td>
				</tr>
				<tr>
					<td width="204" valign="top" align="right">{L_318}</td>
					<td width="486"><input type="text" name="current_bid" size="15" maxlength="15" value="{CURRENT_BID}" disabled>
				</td>
				</tr>
				<tr>
					<td width="204" valign="top" align="right">{L_327}</td>
					<td width="486"><input type="text" name="min_bid" size="40" maxlength="40" value="{MIN_BID}">
				</td>
				</tr>
				<tr>
					<td width="204" valign="top" align="right">{L_319}</td>
					<td width="486"><input type="text" name="quantity" size="40" maxlength="40" value="{QTY}">
				</td>
				</tr>
				<tr>
					<td width="204" valign="top" align="right">{L_320}</td>
					<td width="486"><input type="text" name="reserve_price" size="40" maxlength="40" value="{RESERVE}">
				</td>
				</tr>
				<tr>
					<td width="204" valign="top" align="right">{L_497}</td>
					<td width="486"><input type="text" name="buy_now" size="40" maxlength="40" value="{BUYNOW}">
				</td>
				</tr>
				<tr>
					<td width="204" valign="top" align="right">{L_300}</td>
					<td width="486">{SUSPENDED}</td>
				</tr>
				<tr>
					<td width="204">&nbsp;</td>
					<td width="486"><br><br><input type="submit" name="act" value="{L_089}"></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="id" value="{ID}">
						<input type="hidden" name="action" value="update">
					</td>
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