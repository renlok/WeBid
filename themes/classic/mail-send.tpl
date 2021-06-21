<script type="text/JavaScript">
$(".form1").submit(function() {
	if ($(".to").val() == "")
	{
		return false;
	}
	if ($(".subject").val() == "")
	{
		return false;
	}
	if ($(".message").val() == "")
	{
		return false;
	}
	return true;
});
</script>
<center>
	<form name="form1" id="form1" method="post" action="mail.php">
		<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
		<table width="80%" border="1" style="border-collapse: collapse;">
			<tr>
				<td width="100px" nowrap="nowrap" valign="top"><label for="to">{L_241}:</label></td>
				<td><input name="sendto" type="text" size="40" value="{REPLY_TO}" id="to"></td>
			</tr>
			<tr>
				<td nowrap="nowrap" valign="top"><label for="subject">{L_332}:</label></td>
				<td><input name="subject" type="text" size="40" value="{REPLY_SUBJECT}" id="subject" maxlength="50"></td>
			</tr>
			<tr>
				<td nowrap="nowrap" valign="top"><label for="message">{L_333}:</label></td>
				<td><textarea name="message" rows="5" id="message" style="width:90%"></textarea></td>
			</tr>
		</table>
<!-- IF B_QMKPUBLIC -->
		<p><input type="checkbox" name="public"{REPLY_PUBLIC}> {L_543}</p>
		<input type="hidden" name="is_question" value="0">
<!-- ENDIF -->
		<input type="hidden" name="hash" value="{HASH}">
		<input name="submit" type="submit" value="{L_007}">
	</form>
<!-- IF B_CONVO -->
	<br class="spacer">
	<div style="overflow:scroll; min-height:100px; max-height:500px; width:80%;">
	<!-- BEGIN convo -->
		<div style="border:#000000 solid 1px;{convo.BGCOLOUR}">
			{convo.MSG}
		</div>
	<!-- END convo -->
	</div>
<!-- ENDIF -->
</center>
<br>