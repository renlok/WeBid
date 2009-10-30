<div class="content">
	<div class="tableContent2">
		<div class="titTable2">
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
		<div class="errfont">
			{ERROR}
		</div>
	<!-- ENDIF -->
		<div class="table2">
			<form name="seller" action="email_request.php" method="POST">
				<table width=90% cellpadding="4" cellspacing="0">
					<tr>
						<td>{L_149}</td>
					</tr>
				</table>
				<table width="90%" align="center" cellpadding="4" cellspacing="0">
					<tr>
						<td align=right valign=top width="40%">
							{L_002}
						</td>
						<td width="60%">
							<input type="text" name="TPL_sender_name" size="25" value="{MSG_YNAME}" />
						</td>
					</tr>
					<tr>
						<td align=right valign=top width="40%">
							{L_006}
						</td>
						<td width="60%">
							<input type="text" name="TPL_sender_mail" size="25" value="{MSG_YEMAIL}" />
						</td>
					</tr>
					<tr>
						<td align=right valign=top width="40%">
							{L_333}
						</td>
						<td valign=top width="60%">
							<textarea name="TPL_text" cols="30" rows="8">{MSG_TEXT}</textarea>
							<br>
							<br>
							<input type="hidden" name="user_id" value="{USERID}" />
							<input type="hidden" name="username" value="{USERNAME}" />
							<input type="hidden" name="action" value="proceed" />
							<input type="submit" name="Submit" value="Submit" class="button">
							<input type="reset" name="Submit2" value="Reset" class="button">
						</td>
					</tr>
				</table>
			</form>
		</div>
<!-- ENDIF -->
	</div>
</div>