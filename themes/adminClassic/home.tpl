		<div style="width:25%; float:left;">
				<div style="margin-left:auto; margin-right:auto;">
					<div class="box">
						<h4 class="rounded-top">{L_1061}</h4>
						<div class="rounded-bottom">
							<form name="anotes" action="" method="post">
							<textarea rows="15" name="anotes" class="anotes">{ADMIN_NOTES}</textarea>
							<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
							<input type="submit" name="act" value="{L_submit}">
							</form>
						</div>
					</div>
				</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
<!-- IF UPDATE_AVAILABLE -->
				<div class="alert alert-error">{L_outdated_version}</div>
<!-- ELSE -->
				<div class="alert alert-info">{L_current_version}</div>
<!-- ENDIF -->
					<table width="98%" cellpadding="1" cellspacing="0">
						<tr>
							<th colspan="2">{L_25_0025}</th>
						</tr>
						<tr>
							<td width="172"><strong>{L_site_url}</strong></td>
							<td>{SITEURL}</td>
						</tr>
						<tr class="bg">
							<td><strong>{L_site_name}</strong></td>
							<td>{SITENAME}</td>
						</tr>
						<tr>
							<td><strong>{L_admin_email}</strong></td>
							<td>{ADMINMAIL}</td>
						</tr>
						<tr class="bg">
							<td><strong>{L_25_0026}</strong></td>
							<td>{CRON}</td>
						</tr>
						<tr>
							<td><strong>{L_663}</strong></td>
							<td>{GALLERY}</td>
						</tr>
						<tr class="bg">
							<td><strong>{L_2__0025}</strong></td>
							<td>{BUY_NOW}</td>
						</tr>
						<tr>
							<td><strong>{L_default_currency}</strong></td>
							<td>{CURRENCY}</td>
						</tr>
						<tr class="bg">
							<td><strong>{L_25_0035}</strong></td>
							<td>{TIMEZONE}</td>
						</tr>
						<tr>
							<td><strong>{L_date_format}</strong></td>
							<td>{DATEFORMAT} <small>({DATEEXAMPLE})</small></td>
						</tr>
						<tr>
							<td><strong>{L_email_settings}</strong></td>
							<td>{EMAIL_HANDLER}</td>
						</tr>
						<tr class="bg">
							<td><strong>{L_default_country}</strong></td>
							<td>{DEFULTCONTRY}</td>
						</tr>
						<tr>
							<td><strong>{L_multilingual_support}</strong></td>
							<td>
<!-- BEGIN langs -->
								<p>{langs.LANG}<!-- IF langs.B_DEFAULT --> ({L_current_default_language})<!-- ENDIF --></p>
<!-- END langs -->
							</td>
						</tr>
						<tr class="bg">
							<td><strong>{L_30_0214}</strong></td>
							<td>{THIS_VERSION} ({CUR_VERSION})</td>
						</tr>
					</table>
					<table width="98%" cellpadding="1" cellspacing="0">
						<tr>
							<th colspan="4">{L_25_0031}</th>
						</tr>
						<tr>
							<td width="25%"><strong>{L_25_0055}</strong></td>
							<td width="25%">{C_USERS}</td>
							<td width="25%"><strong>{L_25_0056}</strong></td>
							<td width="25%">
<!-- IF USERCONF eq 0 -->
								<strong>{L_893}</strong>: {C_IUSERS}<br>
								<strong>{L_892}</strong>: {C_UUSERS} (<a href="{SITEURL}admin/listusers.php?usersfilter=admin_approve">{L_5295}</a>)
<!-- ELSE -->
								{C_IUSERS}
<!-- ENDIF -->
							</td>
						</tr>
						<tr class="bg">
							<td><strong>{L_25_0057}</strong></td>
							<td>{C_AUCTIONS}</td>
							<td><strong>{L_354}</strong></td>
							<td>{C_CLOSED}</td>
						</tr>
						<tr>
							<td><strong>{L_25_0059}</strong></td>
							<td>{C_BIDS}</td>
							<td><strong>{L_25_0063}</strong></td>
							<td>
								<p><strong>{L_5161}</strong>: {A_PAGEVIEWS}</p>
								<p><strong>{L_5162}</strong>: {A_UVISITS}</p>
								<p><strong>{L_5163}</strong>: {A_USESSIONS}</p>
							</td>
						</tr>
					</table>
					<table width="98%" cellpadding="1" cellspacing="0">
					<tr>
						<th colspan="2">{L_080}</th>
					</tr>
					<tr>
						<td width="70%">{L_clear_cache_explain}</td>
						<td>
							<form action="?action=clearcache" method="post">
								<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
								<input type="submit" name="submit" value="{L_clear_cache}">
							</form>
						</td>
					</tr>
										<tr class="bg">
						<td width="70%">{L_clear_image_cache_explain}</td>
						<td>
							<form action="?action=clear_image_cache" method="post">
								<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
								<input type="submit" name="submit" value="{L_clear_image_cache}">
							</form>
						</td>
					</tr>
					<tr>
						<td>{L_1030}</td>
						<td>
							<form action="?action=updatecounters" method="post">
								<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
								<input type="submit" name="submit" value="{L_1031}">
							</form>
						</td>
					</tr>
				</table>
			</div>
		</div>
