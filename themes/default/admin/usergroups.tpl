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
				<td width="30"><img src="images/i_use.gif"></td>
				<td class="white">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_448}</td>
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
			<td align="center" class="title">{L_448}</td>
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
				<tr bgcolor="#FFCC00">
					<td><b>{L_449}</b></td>
					<td><b>{L_450}</b></td>
					<td><b>{L_451}</b></td>
					<td><b>{L_578}</b></td>
					<td><b>{L_579}</b></td>
					<td><b>{L_580}</b></td>
                    <td>&nbsp;</td>
				</tr>
<!-- IF B_EDIT -->
				<tr valign="top">
					<td height="22" colspan="5"><b>{L_452}</b></td>
				</tr>
				<tr valign="top">
					<td>{GROUP_ID}</td>
					<td><input type="text" name="group_name" value="{EDIT_NAME}"></td>
					<td><input type="text" name="user_count" value="{USER_COUNT}"></td>
					<td>
                    	<select name="can_sell">
                        	<option value="1" {CAN_SELL_Y}>{L_030}</option>
                        	<option value="0" {CAN_SELL_N}>{L_029}</option>
                        </select>
                    </td>
					<td>
                    	<select name="can_buy">
                        	<option value="1" {CAN_BUY_Y}>{L_030}</option>
                        	<option value="0" {CAN_BUY_N}>{L_029}</option>
                        </select>
                    </td>
					<td>
                    	<select name="auto_join">
                        	<option value="1" {AUTO_JOIN_Y}>{L_030}</option>
                        	<option value="0" {AUTO_JOIN_N}>{L_029}</option>
                        </select>
                    </td>
                    <td><input type="hidden" name="id" value="{GROUP_ID}"></td>
				</tr>
                <tr bgcolor="#FFCC00">
					<td colspan="5">&nbsp;</td>
				</tr>
<!-- ENDIF -->
<!-- BEGIN groups -->
				<tr valign="top">
					<td>{groups.ID}</td>
					<td>{groups.NAME}</td>
					<td>{groups.USER_COUNT}</td>
					<td>{groups.CAN_SELL}</td>
					<td>{groups.CAN_BUY}</td>
					<td>{groups.AUTO_JOIN}</td>
                    <td align="center"><a href="usergroups.php?id={groups.ID}&action=edit">{L_298}</a></td>
				</tr>
<!-- END groups -->
				<tr valign="top">
					<td height="22" colspan="5"><a href="usergroups.php?action=new">{L_518}</a></td>
				</tr>
				<tr>
					<td><input type="hidden" name="action" value="update"></td>
					<td><input type="submit" name="act" value="{L_530}"></td>
                    <td colspan="3">&nbsp;</td>
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