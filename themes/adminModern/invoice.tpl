		<div class="row">
			<div class="col-md-3">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
			<div class="col-md-9">
				<h4>{L_25_0012}&nbsp;&gt;&gt;&nbsp;{L_766}</h4>
				<form action="" method="get">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3">{L_313}</div>
								<div class="col-md-9"><input type="text" name="username" value="{USER_SEARCH}"></div>
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
						<div class="row">
							<div class="col-md-2"><strong>{L_1041}</strong></div>
<!-- IF NO_USER_SEARCH -->
							<div class="col-md-2"><strong>{L_313}</strong></div>
<!-- ENDIF -->
							<div class="col-md-4"><strong>{L_1039}</strong></div>
							<div class="col-md-2"><strong>{L_1053}</strong></div>
							<div class="col-md-2"><strong>{L_560}</strong></div>
						</div>
<!-- BEGIN invoices -->
						<div class="row">
							<div class="col-md-2">
								{L_1041}: {invoices.INVOICE}
								<br>
								{invoices.DATE}
							</div>
<!-- IF NO_USER_SEARCH -->
							<div class="col-md-2">{invoices.USER}</div>
<!-- ENDIF -->
							<div class="col-md-4">{invoices.INFO}</div>
							<div class="col-md-2">{invoices.TOTAL}</div>
							<div class="col-md-2">
								<!-- IF invoices.PAID --><p>{L_898}</p><!-- ENDIF --><a href="{SITEURL}order_print.php?id={invoices.INVOICE}&hash={HASH}" tagret="_blank">{L_1058}</a>
							</div>
						</div>
<!-- END invoices -->
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
