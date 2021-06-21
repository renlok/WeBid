<script type="text/javascript">
function SubmitFriendForm() {
	document.friend.submit();
}
function ResetFriendForm() {
	document.friend.reset();
}
</script>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="grid-margin-btm-md">
			<a class="btn btn-default btn-xs" href="item.php?id={AUCT_ID}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> {L_138}</a>
		</div>
<!-- IF MESSAGE ne '' -->
		<div class="alert alert-success" role="alert">{MESSAGE}</div>
<!-- ELSE -->
	<!-- IF ERROR ne '' -->
		<div class="alert alert-danger" role="alert">
			{ERROR}
		</div>
	<!-- ENDIF -->
		<div class="well">
			<legend>
				{L_645}
			</legend>
			<form name="sendemail" action="send_email.php" method="post">
				<div class="form-group">
					<label>{L_125}</label>
					<input type="hidden" name="seller_nick" class="form-control" value="{SELLER_NICK}">
					{SELLER_NICK}
				</div>
	<!-- IF B_LOGGED_IN eq false -->
				<div class="form-group">
					<label>{L_006}</label>
					<input type="text" name="sender_email" class="form-control" value="">
				</div>
	<!-- ENDIF -->
				<div class="form-group">
					<label>{L_017}</label>
					<input type="hidden" name="item_title" class="form-control" value="{ITEM_TITLE}">
					{ITEM_TITLE}
				</div>
		<!-- your email -->
				<div class="form-group">
					<label>{L_002}</label>
					<input type="text" name="sender_name" class="form-control" value="{YOURUSERNAME}">
				</div>
		<!-- comment -->
				<div class="form-group">
					<label>{L_650}</label>
					<textarea name="sender_question" class="form-control" rows="6">{SELLER_QUESTION}</textarea>
				</div>
				<br>
				<input type="hidden" name="seller_email" value="{SELLER_EMAIL}">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<input type="hidden" name="id" value="{AUCT_ID}">
				<input type="hidden" name="action" value="{L_106}">
				<input type="submit" name="" value="{L_5201}" class="btn btn-primary">
	<!-- IF B_LOGGED_IN -->
				<input type="hidden" name="sender_email" size="25" value="{EMAIL}">
	<!-- ENDIF -->
				<input type="reset" name="" value="{L_035}" class="btn btn-default">
			</form>
		</div>
<!-- ENDIF -->
	</div>
</div>