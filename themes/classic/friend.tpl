<div class="content">
	<div class="tableContent2">
		<div class="titTable2 rounded-top rounded-bottom">{L_139}</div>
		<div class="titTable3">
			<a href="item.php?id={ID}">{L_138}</a>
		</div>
<!-- IF EMAILSENT eq '' -->
		<div align="center" class="padding">
			<p>
			<b>{L_017} : {TITLE}</b><br>
			<b>{L_146} {FRIEND_EMAIL}</b>
			</p>
		</div>
<!-- ELSE -->
	<!-- IF ERROR ne '' -->
		<div class="error-box">
			{ERROR}
		</div>
	<!-- ENDIF -->
		<form name="friend" action="friend.php" method="post">
			<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
			<table width="90%" cellpadding="4" cellspacing="0">
			<tr>
				<td align="right" width="45%"><b>{L_017}</b></td>
				<td align="left">{TITLE}</td>
			</tr>
			<tr>
				<td align="right"><b>{L_140}</b></td>
				<td align="left"><input type="text" name="friend_name" size="25" value="{FRIEND_NAME}">
			</td>
			</tr>
			<tr>
				<td align="right"><b>{L_141}</b></td>
				<td align="left"><input type="text" name="friend_email" size="25" value="{FRIEND_EMAIL}">
			</td>
			</tr>
			<tr>
				<td align="right"><b>{L_002}</b></td>
				<td align="left"><input type="text" name="sender_name" size="25" value="{YOUR_NAME}">
			</td>
			</tr>
			<tr>
				<td align="right"><b>{L_143}</b></td>
				<td align="left"><input type="text" name="sender_email" size="25" value="{YOUR_EMAIL}"></td>
			<tr>
				<td colspan="2">{CAPCHA}</td>
			</tr>
			<tr>
				<td align="right" valign="top"><b>{L_144}</b></td>
				<td align="left">
					<textarea name="sender_comment" cols="30" rows="6">{COMMENT}</textarea>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<input type="hidden" name="id" value="{ID}">
					<input type="hidden" name="item_title" value="{TITLE}">
					<input type="hidden" name="action" value="sendmail">
					<input type="submit" name="" value="{L_5201}" class="button">
					<input type="reset" name="" value="{L_035}" class="button">
				</td>
			</tr>
			</table>
		</form>
<!-- ENDIF -->
	</div>
</div>