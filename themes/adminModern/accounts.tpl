		<link rel="stylesheet" type="text/css" href="{SITEURL}includes/calendar.css">
		<div class="row">
			<div class="col-md-3">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
			<div class="col-md-9">
				<h4>{L_25_0012}&nbsp;&gt;&gt;&nbsp;{L_854}</h4>
				<form action="" method="post">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3">{L_855}</div>
								<div class="col-md-9">
									{L_monthly_report} <input type="radio" name="type" value="m"<!-- IF TYPE eq 'm' --> checked="checked"<!-- ENDIF -->>
									{L_weekly_report} <input type="radio" name="type" value="w"<!-- IF TYPE eq 'w' --> checked="checked"<!-- ENDIF -->>
									{L_5285} <input type="radio" name="type" value="d"<!-- IF TYPE eq 'd' --> checked="checked"<!-- ENDIF -->>
									{L_2__0027} <input type="radio" name="type" value="a"<!-- IF TYPE eq 'a' --> checked="checked"<!-- ENDIF -->>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">{L_856}</div>
								<div class="col-md-9">
									<input type="text" name="from_date" id="from_date" value="{FROM_DATE}" size="20" maxlength="19">
									<script type="text/javascript">
										new tcal ({'id': 'from_date','controlname': 'from_date'});
									</script>
									-
									<input type="text" name="to_date" id="to_date" value="{TO_DATE}" size="20" maxlength="19">
									<script type="text/javascript">
										new tcal ({'id': 'to_date','controlname': 'to_date'});
									</script>
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<button class="btn btn-primary" type="submit" name="act">{L_275}</button>
				</form>
				<br>
				<div class="panel panel-default">
					<div class="panel-body">
<!-- IF PAGNATION -->
						<div class="row">
							<div class="col-md-3"><strong>{L_313}</strong></div>
							<div class="col-md-3"><strong>{L_766}</strong></div>
							<div class="col-md-3"><strong>{L_314}</strong></div>
							<div class="col-md-3"><strong>{L_391}</strong></div>
						</div>
<!-- ELSE -->
						<div class="row">
							<div class="col-md-6">{L_314}</div>
							<div class="col-md-6">{L_857}</div>
						</div>
<!-- ENDIF -->
<!-- BEGIN accounts -->
	<!-- IF PAGNATION -->
						<div class="row">
							<div class="col-md-3">{accounts.RNAME} ({accounts.NICK})</div>
							<div class="col-md-3">{accounts.TEXT}</div>
							<div class="col-md-3">{accounts.DATE}</div>
							<div class="col-md-3">{accounts.AMOUNT}</div>
						</div>
	<!-- ELSE -->
						<div class="row">
							<div class="col-md-6">{accounts.DATE}</div>
							<div class="col-md-6">{accounts.TOTAL}</div>
						</div>
	<!-- ENDIF -->
<!-- END accounts -->
<!-- IF PAGNATION -->
						<div class="row">
							<div class="col-md-12 text-center">
								{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
								<br>
								{PREV}
	<!-- BEGIN pages -->
								{pages.PAGE}&nbsp;&nbsp;
	<!-- END pages -->
								{NEXT}
							</div>
						</div>
<!-- ENDIF -->
					</div>
				</div>
			</div>
		</div>
