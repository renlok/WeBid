<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="well">
			<legend>
				{L_334} {USERNAME}
			</legend>
			<div class="grid-margin-btm-md">
				<a class="btn btn-default btn-xs" href="item.php?id={AUCTION_ID}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> {L_138}</a>
				<a class="btn btn-warning btn-xs" href="profile.php?user_id={USERID}">{L_206}</a>
			</div>
<!-- IF B_SENT -->
			<div class="alert alert-success" role="alert">
				<p>{L_337} {USERNAME}</p>
			</div>
<!-- ELSE -->
	<!-- IF ERROR ne '' -->
			<div class="alert alert-danger" role="alert">
				{ERROR}
			</div>
	<!-- ENDIF -->
			<form name="seller" action="email_request.php" method="post">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<div class="alert alert-info" role="alert">{L_149}</div>
				<div class="form-group">
					<label>{L_333}</label>
					<textarea name="TPL_text" class="form-control" rows="8">{MSG_TEXT}</textarea>
				</div>
				<input type="hidden" name="user_id" value="{USERID}">
				<input type="hidden" name="username" value="{USERNAME}">
				<input type="hidden" name="action" value="proceed">
				<div class="form-group text-center">
					<input type="submit" name="Submit" value="{L_submit}" class="btn btn-primary">
				</div>
			</form>
<!-- ENDIF -->
		</div>
	</div>
</div>