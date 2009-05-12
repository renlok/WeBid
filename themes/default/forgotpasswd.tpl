<div class="titTable2">
	{L_215}
</div>
{L_ERROR}
<div class="padding" align="center">
<!-- IF B_FIRST -->
	<form name="user_login" action="" method="post">
	<table width="80%" cellspacing="0" cellpadding="4" border="0">
	<tr>
		<td colspan="2" align="center">{L_MSG}</td>
	</tr>
	<tr>
		<td width="40%" align="right"><b>{L_UNAME}</b></td>
		<td width="60%">
			<input type="text" NAME="TPL_username" size="25" value="{USERNAME}">
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><br>
			<input type="submit" name="" value="{L_5431}" class="button">
		</td>
	</tr>
	</table>
	<input type="hidden" name="action" value="ok">
	</form>
<!-- ELSE -->
	{L_217}
<!-- ENDIF -->
</div>