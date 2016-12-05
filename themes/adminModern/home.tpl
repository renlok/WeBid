		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">{L_1061}</div>
					<div class="panel-body">
						<form name="anotes" action="" method="post">
							<textarea rows="15" name="anotes" class="form-control">{ADMIN_NOTES}</textarea>
							<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
							<br>
							<button class="btn btn-primary" type="submit" name="act">{L_submit}</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-9">
<!-- IF UPDATE_AVAILABLE -->
				<div class="alert alert-danger" role="alert">{L_outdated_version}</div>
<!-- ELSE -->
				<div class="alert alert-info" role="alert">{L_current_version}</div>
<!-- ENDIF -->
				<div class="panel panel-default">
					<div class="panel-heading"><strong>{L_25_0025}</strong></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-3"><strong>{L_site_url}</strong></div>
							<div class="col-md-9">{SITEURL}</div>
						</div>
						<div class="row">
							<div class="col-md-3"><strong>{L_site_name}</strong></div>
							<div class="col-md-9">{SITENAME}</div>
						</div>
						<div class="row">
							<div class="col-md-3"><strong>{L_admin_email}</strong></div>
							<div class="col-md-9">{ADMINMAIL}</div>
						</div>
						<div class="row">
							<div class="col-md-3"><strong>{L_25_0026}</strong></div>
							<div class="col-md-9">{CRON}</div>
						</div>
						<div class="row">
							<div class="col-md-3"><strong>{L_663}</strong></div>
							<div class="col-md-9">{GALLERY}</div>
						</div>
						<div class="row">
							<div class="col-md-3"><strong>{L_2__0025}</strong></div>
							<div class="col-md-9">{BUY_NOW}</div>
						</div>
						<div class="row">
							<div class="col-md-3"><strong>{L_default_currency}</strong></div>
							<div class="col-md-9">{CURRENCY}</div>
						</div>
						<div class="row">
							<div class="col-md-3"><strong>{L_25_0035}</strong></div>
							<div class="col-md-9">{TIMEZONE}</div>
						</div>
						<div class="row">
							<div class="col-md-3"><strong>{L_date_format}</strong></div>
							<div class="col-md-9">{DATEFORMAT} <small>({DATEEXAMPLE})</small></div>
						</div>
						<div class="row">
							<div class="col-md-3"><strong>{L_email_settings}</strong></div>
							<div class="col-md-9">{EMAIL_HANDLER}</div>
						</div>
						<div class="row">
							<div class="col-md-3"><strong>{L_default_country}</strong></div>
							<div class="col-md-9">{DEFULTCONTRY}</div>
						</div>
						<div class="row">
							<div class="col-md-3"><strong>{L_multilingual_support}</strong></div>
							<div class="col-md-9">
<!-- BEGIN langs -->
								<p>{langs.LANG}<!-- IF langs.B_DEFAULT --> ({L_current_default_language})<!-- ENDIF --></p>
<!-- END langs -->
							</div>
						</div>
						<div class="row">
							<div class="col-md-3"><strong>{L_30_0214}</strong></div>
							<div class="col-md-9">{THIS_VERSION} ({CUR_VERSION})</div>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading"><strong>{L_25_0031}</strong></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-3"><strong>{L_25_0055}</strong></div>
							<div class="col-md-3">{C_USERS}</div>
							<div class="col-md-3"><strong>{L_25_0056}</strong></div>
							<div class="col-md-3">
<!-- IF USERCONF eq 0 -->
								<strong>{L_893}</strong>: {C_IUSERS}<br>
								<strong>{L_892}</strong>: {C_UUSERS} (<a href="{SITEURL}admin/listusers.php?usersfilter=admin_approve">{L_5295}</a>)
<!-- ELSE -->
								{C_IUSERS}
<!-- ENDIF -->
							</div>
						</div>
						<div class="row">
							<div class="col-md-3"><strong>{L_25_0057}</strong></div>
							<div class="col-md-3">{C_AUCTIONS}</div>
							<div class="col-md-3"><strong>{L_354}</strong></div>
							<div class="col-md-3">{C_CLOSED}</div>
						</div>
						<div class="row">
							<div class="col-md-3"><strong>{L_25_0059}</strong></div>
							<div class="col-md-3">{C_BIDS}</div>
							<div class="col-md-3"><strong>{L_25_0063}</strong></div>
							<div class="col-md-3">
								<strong>{L_5161}</strong>: {A_PAGEVIEWS}<br>
								<strong>{L_5162}</strong>: {A_UVISITS}<br>
								<strong>{L_5163}</strong>: {A_USESSIONS}<br>
							</div>
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading"><strong>{L_080}</strong></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-9">{L_clear_cache_explain}</div>
							<div class="col-md-3">
								<form action="?action=clearcache" method="post">
									<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
									<button class="btn btn-primary" type="submit" name="submit">{L_clear_cache}</button>
								</form>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-9">{L_clear_image_cache_explain}</div>
							<div class="col-md-3">
								<form action="?action=clear_image_cache" method="post">
									<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
									<button class="btn btn-primary" type="submit" name="submit">{L_clear_image_cache}</button>
								</form>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-9">{L_1030}</div>
							<div class="col-md-3">
								<form action="?action=updatecounters" method="post">
									<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
									<button class="btn btn-primary" type="submit" name="submit">{L_1031}</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
