<div class="row">
	<div class="col-md-8 col-md-offset-2">
<!-- IF ERROR ne '' -->
		<div class="alert alert-danger" role="alert">
			{ERROR}
		</div>
<!-- ENDIF -->
		<div class="well">
			<legend>
				{L_207}
			</legend>
			<form class="form-horizontal" name="addfeedback" action="{SITEURL}feedback.php?wid={WID}&sid={SID}&ws={WS}" method="post">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<div class="form-group">
					<label class="col-sm-3 control-label">{L_168}:</label>
					<div class="col-sm-9">
						<p class="form-control-static"><a href="{SITEURL}item.php?id={AUCT_ID}">{AUCT_TITLE}</a></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">{SBMSG}:</label>
					<div class="col-sm-9">
						<p class="form-control-static"><a href="{SITEURL}profile.php?user_id={THEM}&auction_id={AUCT_ID}">{USERNICK}</a> (<a href="{SITEURL}feedback.php?id={THEM}&faction=show">{USERFB}</a>) {USERFBIMG}</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">{L_503}:</label>
					<div class="col-sm-9"><div class="radio">
						<label><input type="radio" name="TPL_rate" value="1" {RATE1}>
						<img src="{SITEURL}images/positive.png" border="0" alt="+1"></label>
						<label><input type="radio" name="TPL_rate" value="0" {RATE2}>
						<img src="{SITEURL}images/neutral.png" border="0" alt="0"></label>
						<label><input type="radio" name="TPL_rate" value="-1" {RATE3}>
						<img src="{SITEURL}images/negative.png" border="0" alt="-1"></label></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">{L_227}:</label>
					<div class="col-sm-9">
						<textarea name="TPL_feedback" rows="10" class="form-control">{FEEDBACK}</textarea>
					</div>
				</div>
<!-- IF B_USERAUTH -->
				<div class="form-group">
					<label class="col-sm-3 control-label">{L_188}:</label>
					<div class="col-sm-9">
						<input type="password" name="TPL_password" size="20" class="form-control" value="">
					</div>
				</div>
<!-- ENDIF -->
				<div class="form-group">
					<div class="text-center">
						<input type="submit" name="" value="{L_207}" class="btn btn-primary">
						<input type="reset" name="" class="btn btn-default">
					</div>
				</div>
				<input type="hidden" name="TPL_nick_hidden" value="{USERNICK}">
				<input type="hidden" name="addfeedback" value="true">
				<input type="hidden" name="auction_id" value="{AUCT_ID}">
			</form>
		</div>
	</div>
</div>