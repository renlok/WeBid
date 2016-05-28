<div class="content">
	<div class="tableContent2">
		<div class="titTable2 rounded-top rounded-bottom">
			{L_207}
		</div>
<!-- IF ERROR ne '' -->
		<div class="error-box">
			{ERROR}
		</div>
<!-- ENDIF -->
		<div class="table2" style="padding:20px;">
			<form name="addfeedback" action="{SITEURL}feedback.php?wid={WID}&sid={SID}&ws={WS}" method="post">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<table width="100%" border="0" cellpadding="4" cellspacing="0" >
					<tr>
						<td width="40%" align="right"><b>{L_168}:</b></td>
						<td>
							<a href="{SITEURL}item.php?id={AUCT_ID}">{AUCT_TITLE}</a>
						</td>
					</tr>
					<tr>
						<td width="40%" align="right"><b>{SBMSG}:</b></td>
						<td>
							<a href="{SITEURL}profile.php?user_id={THEM}&auction_id={AUCT_ID}">{USERNICK}</a> (<a href="{SITEURL}feedback.php?id={THEM}&faction=show">{USERFB}</a>) {USERFBIMG}
						</td>
					</tr>
					<tr>
						<td align="right"><b>{L_503}:</b> </td>
						<td>
							<input type="radio" name="TPL_rate" value="1" {RATE1}>
							<img src="{SITEURL}images/positive.png" border="0" alt="+1">
							<input type="radio" name="TPL_rate" value="0" {RATE2}>
							<img src="{SITEURL}images/neutral.png" border="0" alt="0">
							<input type="radio" name="TPL_rate" value="-1" {RATE3}>
							<img src="{SITEURL}images/negative.png" border="0" alt="-1">
						</td>
					</tr>
					<tr>
						<td align="right" valign="top"><b>{L_227}:</b></td>
						<td>
							<textarea name="TPL_feedback" rows="10" cols="50">{FEEDBACK}</textarea>
						</td>
					</tr>
<!-- IF B_USERAUTH -->
					<tr>
						<td align="right"><b>{L_188}:</b></td>
						<td>
							<input type="password" name="TPL_password" size="20" maxlength="20" value="">
						</td>
					</tr>
<!-- ENDIF -->
					<tr>
						<td colspan="2" align="center"><br>
							<input type="submit" name="" value="{L_207}" class="button">
							<input type="reset" name="" class="button">
						</td>
					</tr>
				</table>
				<input type="hidden" name="TPL_nick_hidden" value="{USERNICK}">
				<input type="hidden" name="addfeedback" value="true">
				<input type="hidden" name="auction_id" value="{AUCT_ID}">
			</form>
		</div>
	</div>
</div>