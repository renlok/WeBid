<div class="content">
	<div class="titTable2">
		{L_181}
	</div>
	<div class="table2">
<!-- IF ERROR ne '' -->
		<div class="error-box">
			{ERROR}
		</div>
<!-- ENDIF -->
		<div class="padding centre">
		<table width="676" border="0" cellpadding="6" class="centre">
			<tr>
				<td width="301">
					<h2>{L_862}</h2>
					<form name="user_login" action="{SITEURL}user_login.php" method="post">
						<p class="smallpadding">
							{L_187}<br>
							<input type="text" autofocus name="username" size="20" maxlength="20" value="{USER}">
						</p>
						<p class="smallpadding">
							{L_004}<br>
							<input type="password" name="password" size="20" maxlength="20" value="">
						</p>
						<p>
							<input type="submit" name="input" value="Login" class="button">
							<input type="hidden" name="action" value="login">
							<input type="checkbox" name="rememberme" value="1">&nbsp;{L_25_0085}
						</p>
						<p>
							<a href="forgotpasswd.php">{L_215}</a>
						</p>
					</form>
				</td>
				<td width="339">
					{L_863}
				</td>
			</tr>
		</table>
		</div>
	</div>
</div>