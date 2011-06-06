<div class="content">
	<div class="titTable2">
		{L_181}
	</div>
	<div class="table2">
		<form name="user_login" action="{SSLURL}user_login.php" method="post">
			<table width="100%" cellspacing="0" cellpadding="4" border="0">
<!-- IF ERROR ne '' -->
                <tr>
                	<td colspan="2" class="errfont">{ERROR}</td>
                </tr>
<!-- ENDIF -->
				<tr>
					<td width="40%" align="right"><b>{L_187}</b> </td>
					<td width="60%">
						<input type="text" name="username" size="20" maxlength="20" value="{USER}">
					</td>
				</tr>
				<tr>
					<td align="right"><b>{L_004}</b> </td>
					<td>
						<input type="password" name="password" size="20" maxlength="20" value="">
					</td>
				</tr>
				<tr>
					<td align="right">&nbsp;</td>
					<td>
						<input type="checkbox" name="rememberme" value="1">&nbsp;{L_25_0085}
					</td>
				</tr>
				<tr>
					<td align="right">&nbsp;</td>
					<td>
						<input type="submit" name="" value="{L_052}"  class="button">
						<input type="hidden" name="action" value="login">
					</td>
				</tr>
				<tr>
					<td align="right">&nbsp;</td>
					<td><a href="forgotpasswd.php">{L_215}</a> </td>
				</tr>
			</table>
		</form>
	</div>
</div>