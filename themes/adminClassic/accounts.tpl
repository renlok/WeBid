		<link rel="stylesheet" type="text/css" href="{SITEURL}includes/calendar.css">
		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_854}&nbsp;&gt;&gt;&nbsp;{L_854}</h4>
					<div class="plain-box">
						<form action="" method="post">
						<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
						<table cellpadding="0" cellspacing="0" width="100%" class="blank">
						<tr>
							<td>{L_855}</td>
							<td>
								{L_monthly_report} <input type="radio" name="type" value="m"<!-- IF TYPE eq 'm' --> checked="checked"<!-- ENDIF -->>
								{L_weekly_report} <input type="radio" name="type" value="w"<!-- IF TYPE eq 'w' --> checked="checked"<!-- ENDIF -->>
								{L_5285} <input type="radio" name="type" value="d"<!-- IF TYPE eq 'd' --> checked="checked"<!-- ENDIF -->>
								{L_2__0027} <input type="radio" name="type" value="a"<!-- IF TYPE eq 'a' --> checked="checked"<!-- ENDIF -->>
							</td>
						</tr>
						<tr>
							<td>{L_856}</td>
							<td>
							<input type="text" name="from_date" id="from_date" value="{FROM_DATE}" size="20" maxlength="19">
							<script type="text/javascript">
								new tcal ({'id': 'from_date','controlname': 'from_date'});
							</script>
							-
							<input type="text" name="to_date" id="to_date" value="{TO_DATE}" size="20" maxlength="19">
							<script type="text/javascript">
								new tcal ({'id': 'to_date','controlname': 'to_date'});
							</script>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="submit" name="act" value="{L_275}">
							</td>
						</tr>
						</table>
						</form>
					</div>
					<table width="98%" cellpadding="0" cellspacing="0">
<!-- IF PAGNATION -->
						<tr>
							<th><b>{L_313}</b></th>
							<th><b>{L_766}</b></th>
							<th align="center"><b>{L_314}</b></th>
							<th align="center"><b>{L_391}</b></th>
						<tr>
<!-- ELSE -->
						<tr>
							<th><b>{L_314}</b></th>
							<th align="center"><b>{L_857}</b></th>
						<tr>
<!-- ENDIF -->
<!-- BEGIN accounts -->
	<!-- IF PAGNATION -->
						<tr<!-- IF accounts.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF -->>
							<td>{accounts.RNAME} ({accounts.NICK})</td>
							<td>{accounts.TEXT}</td>
							<td align="center">{accounts.DATE}</td>
							<td align="center">{accounts.AMOUNT}</td>
						</tr>
	<!-- ELSE -->
						<tr<!-- IF accounts.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF -->>
							<td>{accounts.DATE}</td>
							<td align="center">{accounts.TOTAL}</td>
						</tr>
	<!-- ENDIF -->
<!-- END accounts -->
					</table>
<!-- IF PAGNATION -->
					<table width="98%" cellpadding="0" cellspacing="0" class="blank">
						<tr>
							<td align="center">
								{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
								<br>
								{PREV}
	<!-- BEGIN pages -->
								{pages.PAGE}&nbsp;&nbsp;
	<!-- END pages -->
								{NEXT}
							</td>
						</tr>
					</table>
<!-- ENDIF -->
				</div>
			</div>
