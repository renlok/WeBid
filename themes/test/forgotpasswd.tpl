<div class="titTable2 rounded-top rounded-bottom">
	{L_215}
</div>
<div class="padding" align="center">
<!-- IF B_FIRST -->
	<!-- IF ERROR ne '' -->
	<div class="error-box">
		{ERROR}
	</div>
	<!-- ENDIF -->
	<form name="user_login" action="" method="post">
		<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
		<table width="80%" cellspacing="0" cellpadding="4" border="0">
		<tr>
			<td colspan="2" align="center">{L_2__0039}</td>
		</tr>
		<tr>
			<td width="40%" align="right"><b>{L_username}</b></td>
			<td width="60%">
				<input type="text" NAME="TPL_username" size="25" value="{USERNAME}">
			</td>
		</tr>
		<tr>
			<td align="right"><b>{L_006}</b></td>
			<td>
				<input type="text" NAME="TPL_email" size="25" value="{EMAIL}">
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