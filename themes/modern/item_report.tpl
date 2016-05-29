<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<legend>{L_report_this_item}</legend>
		<a class="btn btn-default btn-xs grid-margin-btm" href="item.php?id={ID}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> {L_138}</a>
<!-- IF ITEMREPORTED eq '' -->
		<div class="alert alert-success" role="alert">
			<p>
				<b>{L_017} : {TITLE}</b><br>
				<b>{L_auction_has_been_reported}</b>
			</p>
		</div>
<!-- ELSE -->
	<!-- IF ERROR ne '' -->
		<div class="alert alert-danger" role="alert">
			{ERROR}
		</div>
	<!-- ENDIF -->
		<div class="well">
			<form class="form-horizontal" name="item_report" action="item_report.php" method="post">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<div class="alert alert-info" role="alert">{TITLE}</div>
				<div class="form-group">
					<label class="col-sm-3 control-label" for="reason">{L_reason_for_report}</label>
					<div class="col-sm-9">
						<select class="form-control" id="reason" name="reason">
							<option value="0">{L_report_reason_select}</option>
							<option value="1">{L_report_reason_copy}</option>
							<option value="2">{L_report_reason_counterfeit}</option>
							<option value="3">{L_report_reason_prohibited}</option>
							<option value="4">{L_report_reason_terms_and_conditions}</option>
							<option value="5">{L_report_reason_stolen}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="capchabox2">{CAPCHA}</div>
				</div>
				<div class="form-group">
					<div class="text-center">
						<input type="hidden" name="id" value="{ID}">
						<input type="hidden" name="action" value="reportitem">
						<input type="submit" name="" value="{L_report_item}" class="btn btn-primary">
					</div>
				</div>
			</form>
		</div>
<!-- ENDIF -->
	</div>
</div>