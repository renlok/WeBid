<html>
<head>
	<link rel="stylesheet" type="text/css" href="{SITEURL}admin/style.css" />
</head>
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td background="{SITEURL}admin/images/bac_barint.gif">
        <table width="100%" border="0" cellspacing="5" cellpadding="0">
            <tr>
                <td width="30"><img src="{SITEURL}admin/images/i_con.gif"></td>
                <td class="white">{L_25_0018}&nbsp;&gt;&gt;&nbsp;{L_5031}</td>
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
			<td align="center" class="title">{L_5031}</td>
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
				<tr>
					<td width="24%">{L_5034}</td>
					<td width="76%">
						<input type="text" name="name" size="25" maxlength="255" value="{NAME}">
					</td>
				</tr>
				<tr>
					<td>{L_5035}</td>
					<td>
						<p>{L_5036}</p>
						<input type="text" name="msgstoshow" size="4" maxlength="4" value="{MSGTOSHOW}">
					</td>
				</tr>
				<tr>
					<td>{L_5037}</td>
					<td>
						<input type="radio" name="active" value="1"<!-- IF B_ACTIVE --> checked="checked"<!-- ENDIF -->> {L_5038}
						<input type="radio" name="active" value="2"<!-- IF B_DEACTIVE --> checked="checked"<!-- ENDIF -->> {L_5039}
					</td>
				</tr>
				<tr>
					<td>
						<input type="hidden" name="action" value="insert">
					</td>
					<td>
						<input type="submit" name="Submit" value="{L_5029}">
					</td>
				</tr>
				</table>	
				</form>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr align="center">
	<td bgcolor="#EEEEEE"><a href="boards.php">{L_5033}</a></td>
</tr>
</table>

<!-- INCLUDE footer.tpl -->
