<script type="text/javascript">
function SubmitFriendForm(){
	document.friend.submit();
}
function ResetFriendForm(){
	document.friend.reset();
}
</script>
<div class="content">
	<div class="tableContent2">
		<div class="titTable2">
			{L_645}
		</div>
		<div class="titTable3">
			<a href="item.php?id={AUCT_ID}">{L_138}</a>
		</div>
<!-- IF MESSAGE ne '' -->
		<div align="center" class="padding">{MESSAGE}</div>
<!-- ELSE -->
	<!-- IF ERROR ne '' -->
		<div class="error-box">
			{ERROR}
		</div>
	<!-- ENDIF -->
		<table WIDTH="100%" >
			<tr>
				<td>
					<form name="sendemail" action="send_email.php" method="post">
						<table WIDTH="90%" border="0" cellpadding="4" cellspacing="0" class="content">
							<tr>
								<td width="40%" align=right>
									<b>{L_125}</b>
								</td>
								<td width="60%">
									<input type="hidden" name="seller_nick" size="25" value="{SELLER_NICK}">
									{SELLER_NICK}
								</td>
							</tr>
	<!-- IF B_LOGGED_IN eq false -->
							<tr>
								<td align=right>
									<b>{L_006}</b>
								</td>
								<td>
									<input type="text" name="sender_email" size="25" value="">
								</td>
							</tr>
	<!-- ENDIF -->
							<tr>
								<td align=right>
									<b>{L_017}</b>
								</td>
								<td>
									<input type="hidden" name="item_title" size="25" value="{ITEM_TITLE}">
									{ITEM_TITLE}
								</td>
							</tr>
							<!-- your email -->
							<tr>
								<td align=right>
									<b>{L_002}</b>
								</td>
								<td>
									<input type="text" name="sender_name" size="25" value="{YOURUSERname}">
								</td>
							</tr>
							<!-- comment -->
							<tr>
								<td align="right" valign="top">
									<b>{L_650}</b>
								</td>
								<td>
									<textarea name="sender_question" cols="35" rows="6">{SELLER_QUESTION}</textarea>
									<br><br>
									<input type="hidden" name="seller_email" value="{SELLER_EMAIL}">
									<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
									<input type="hidden" name="id" value="{AUCT_ID}">
									<input type="hidden" name="action" value="{L_106}"> <input type="submit" name="" value="{L_5201}" class="button">
	<!-- IF B_LOGGED_IN -->
									<input type="hidden" name="sender_email" size="25" value="{EMAIL}">
	<!-- ENDIF -->
									<input type=reset name="" value="{L_035}" class="button">
								</td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>
<!-- ENDIF -->
	</div>
</div>