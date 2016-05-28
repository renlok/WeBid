<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<legend>
			{L_5030}
		</legend>
		<div class="row">
			<div class="col-md-12 grid-margin-btm">
				<a class="btn btn-default btn-xs" href="{SITEURL}boards.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> {L_5058}</a>
			</div>
<!-- IF B_LOGGED_IN eq false -->
			<div class="alert alert-danger" role="alert">
				{L_5056}
			</div>
<!-- ENDIF -->
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-info text-center" role="alert">{L_30_0181} {BOARD_NAME}</div>
<!-- IF ERROR ne '' -->
				<div class="alert alert-danger text-center" role="alert">{ERROR}</div>
<!-- ENDIF -->
				<form name="messageboard" action="" method="post">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="hidden" name="action" value="insertmessage">
					<input type="hidden" name="board_id" value="{BOARD_ID}">
					<textarea class="form-control" name="newmessage"  rows="5"></textarea>
					<br>
					<div class="text-center">
						<input type="submit" name="Submit" value="{L_5057}" class="btn btn-primary">
					</div>
				</form>
				<div class="row">
					<div class="col-md-12">
						<legend>{L_5059}</legend>
<!-- BEGIN msgs -->
						<div class="well well-sm">
	<!-- IF msgs.USERNAME ne '' -->
							<small>{L_5060}</small> <b>{msgs.USERNAME}</b> - <small>{msgs.POSTED}</small><hr />
	<!-- ELSE -->
							{L_5060} <b>{L_5061}</b> - {msgs.POSTED}
	<!-- ENDIF -->
							<span class="glyphicon glyphicon-envelope" style="margin-right: 10px;" aria-hidden="true"></span>{msgs.MSG}
						</div>
<!-- END msgs -->
					</div>
				</div>
				<div class="col-md-12 text-center">
					{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
					<br>
					{PREV}
<!-- BEGIN pages -->
					{pages.PAGE}&nbsp;
<!-- END pages -->
					{NEXT}
				</div>
			</div>
		</div>
	</div>
</div>