<div class="content">
	<div class="tableContent2">
		<div class="titTable2 rounded-top rounded-bottom">
			{L_334} {USERNAME}
		</div>
		<div class="titTable3">
			<a href="profile.php?user_id={USERID}">{L_206}</a> |
			<a href="item.php?id={AUCTION_ID}">{L_138}</a>
		</div>
<!-- IF B_SENT -->
		<div align="center">
			<p>{L_337} {USERNAME}</p>
		</div>
<!-- ELSE -->
	<!-- IF ERROR ne '' -->
		<div class="error-box">
			{ERROR}
		</div>
	<!-- ENDIF -->
		<div class="table2">
			<form name="seller" action="email_request.php" method="post">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<table width=90% cellpadding="4" cellspacing="0">
					<tr>
						<td>{L_149}</td>
					</tr>
				</table>
				<table width="90%" align="center" cellpadding="4" cellspacing="0">
					<tr>
						<td align="right" valign="top" width="40%">
							{L_333}
						</td>
						<td valign="top" width="60%">
							<p><textarea name="TPL_text" cols="30" rows="8">{MSG_TEXT}</textarea></p>
							<input type="hidden" name="user_id" value="{USERID}">
							<input type="hidden" name="username" value="{USERNAME}">
							<input type="hidden" name="action" value="proceed">
							<input type="submit" name="Submit" value="{L_submit}" class="button">
						</td>
					</tr>
				</table>
			</form>
		</div>
<!-- ENDIF -->
	</div>
</div>