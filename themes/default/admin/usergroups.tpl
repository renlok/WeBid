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
				<td width="30"><img src="images/i_use.gif"></td>
				<td class="white">Users&nbsp;&gt;&gt;&nbsp;User Groups</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="center" valign="middle">&nbsp;</td>
</tr>
<tr>
	<td align="center" valign="middle">
		<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
		<tr>
			<td align="center" class="title">User Groups</td>
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
				<tr  bgcolor="#FFCC00">
					<td><b>Group ID</b></td>
					<td><b>Group Name</b></td>
					<td><b>User Count</b></td>
					<td><b>Can Sell</b></td>
					<td><b>Can Buy</b></td>
				</tr>
<!-- BEGIN groups -->
				<tr valign="top">
					<td>{groups.ID}</td>
					<td>{groups.NAME}</td>
					<td>{groups.USER_COUNT}</td>
					<td>{groups.CAN_SELL}</td>
					<td>{groups.CAN_BUY}</td>
				</tr>
<!-- END groups -->
				<tr valign="top">
					<td height="22" colspan="5">&nbsp;</td>
				</tr>
				<tr>
					<td><input type="hidden" name="action" value="update"></td>
					<td><input type="submit" name="act" value="{L_530}"></td>
                    <td colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="5">&nbsp;</td>
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