<!-- INCLUDE user_menu_header.tpl -->

<script type="text/javascript">
$(document).ready(function() {
	$("#checkboxall").click(function() {
		var checked_status = this.checked
		$(".deleteid").each(function() {
			this.checked = checked_status;
		});
	});
});
</script>
<!-- IF ERROR ne '' -->
<div class="error-box">{ERROR}</div>
<!-- ENDIF -->
<!-- IF REPLY_X eq 1 -->
	<!-- INCLUDE mail-send.tpl -->
<!-- ENDIF -->
<form action="mail.php" method="post" name="deletemessages">
	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
	<table width="100%" border="0" cellspacing="1" cellpadding="4" align="center">
		<thead>
			<tr>
				<td class="titTable1" width="100">{WHENSENT}</td>
				<td class="titTable1">{TITLE}</td>
				<td class="titTable1" width="200">{SENTFROM}</td>
				<td class="titTable1" nowrap="nowrap">{L_2__0028}<br><input type="checkbox" name="" id="checkboxall" value=""></td>
			</tr>
		</thead>
		<tbody>
<!-- IF MSGCOUNT eq 0 -->
			<tr>
				<td colspan="5">{L_2__0029}</td>
			</tr>
<!-- ELSE -->
	<!-- BEGIN msgs -->
			<tr>
				<td><span class="smaller">{msgs.SENT}</span></td>
				<td><a href="yourmessages.php?id={msgs.ID}">{msgs.SUBJECT}</a></td>
				<td>{msgs.SENDER}</td>
				<td><input type="checkbox" name="deleteid[]" class="deleteid" value="{msgs.ID}"></td>
			</tr>
	<!-- END msgs -->
<!-- ENDIF -->
		</tbody>
	</table>
	<div align="center">
		<input type="submit" name="submit" value="{L_008}"  OnClick="if ( !confirm('{L_2__0031}') ) { return false; }">
	</div>
</form>
<!-- INCLUDE user_menu_footer.tpl -->
