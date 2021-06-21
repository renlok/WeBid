<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<legend>{L_139}</legend>
		<a class="btn btn-default btn-xs grid-margin-btm" href="item.php?id={ID}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> {L_138}</a>
<!-- IF EMAILSENT eq '' -->
		<div class="alert alert-success" role="alert">
			<p>
				<b>{L_017} : {TITLE}</b><br>
				<b>{L_146} {FRIEND_EMAIL}</b>
			</p>
		</div>
<!-- ELSE -->
	<!-- IF ERROR ne '' -->
		<div class="alert alert-danger" role="alert">
			{ERROR}
		</div>
	<!-- ENDIF -->
		<div class="well">
			<form class="form-horizontal" name="friend" action="friend.php" method="post">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<div class="alert alert-info" role="alert">{TITLE}</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">{L_140}</label>
					<div class="col-sm-9"><input type="text" name="friend_name" class="form-control" value="{FRIEND_NAME}"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">{L_141}</label>
					<div class="col-sm-9"><input type="text" name="friend_email" class="form-control" value="{FRIEND_EMAIL}"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">{L_002}</label>
					<div class="col-sm-9"><input type="text" name="sender_name" class="form-control" value="{YOUR_NAME}"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">{L_143}</label>
					<div class="col-sm-9"><input type="text" name="sender_email" class="form-control" value="{YOUR_EMAIL}"></div>
				</div>
				<div class="form-group">
					<div class="capchabox2">{CAPCHA}</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">{L_144}</label>
					<div class="col-sm-9">
						<textarea name="sender_comment" class="form-control" rows="6">{COMMENT}</textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="text-center">
						<input type="hidden" name="id" value="{ID}">
						<input type="hidden" name="item_title" value="{TITLE}">
						<input type="hidden" name="action" value="sendmail">
						<input type="submit" name="" value="{L_5201}" class="btn btn-primary">
						<input type="reset" name="" value="{L_035}" class="btn btn-default">
					</div>
				</div>
			</form>
		</div>
<!-- ENDIF -->
	</div>
</div>