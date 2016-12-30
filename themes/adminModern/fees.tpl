		<div class="row">
			<div class="col-md-3">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
			<div class="col-md-9">
				<h4>{L_25_0012}&nbsp;&gt;&gt;&nbsp;{L_842}</h4>
<!-- IF B_NOT_SETUP_CORRECTLY -->
				<div class="alert alert-danger" role="alert"><b>{L_1144}</b></div>
<!-- ENDIF -->
<!-- IF FEETYPE ne '' -->
				<form name="errorlog" action="" method="post">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4>{FEETYPE}</h4>
	<!-- IF B_SINGLE -->
							<div class="row">
								<div class="col-md-3">{L_263}</div>
								<div class="col-md-9"><input type="text" size="12" name="value" value="{VALUE}"> {CURRENCY}</div>
							</div>
	<!-- ELSE -->
							<div class="row">
								<div class="col-md-2"><strong>&nbsp;</strong></div>
								<div class="col-md-2"><strong>{L_240} ({CURRENCY})</strong></div>
								<div class="col-md-2"><strong>{L_241} ({CURRENCY})</strong></div>
								<div class="col-md-2"><strong>{L_391} ({CURRENCY})</strong></div>
								<div class="col-md-2"><strong>{L_392}</strong></div>
								<div class="col-md-2"><strong>{L_008}</strong></div>
							</div>
		<!-- BEGIN fees -->
							<div class="row">
								<div class="col-md-2">&nbsp;</div>
								<div class="col-md-2">
									<input type="hidden" name="tier_id[]" value="{fees.ID}">
									<input name="fee_from[]" type="text" value="{fees.FROM}" size="9">
								</div>
								<div class="col-md-2"><input name="fee_to[]" type="text" value="{fees.TO}" size="9"></div>
								<div class="col-md-2"><input name="value[]" type="text" value="{fees.VALUE}" size="9"></div>
								<div class="col-md-2">
									<select name="type[]">
										<option value="flat"{fees.FLATTYPE}>{L_393}</option>
										<option value="perc"{fees.PERCTYPE}>{L_357}</option>
									</select>
								</div>
								<div class="col-md-2"><input type="checkbox" name="fee_delete[]" value="{fees.ID}"></div>
							</div>
		<!-- END fees -->
							<div class="row">
								<div class="col-md-2">{L_394}</div>
								<div class="col-md-2"><input name="new_fee_from" type="text" size="9" value="{FEE_FROM}"></div>
								<div class="col-md-2"><input name="new_fee_to" type="text" size="9" value="{FEE_TO}"></div>
								<div class="col-md-2"><input name="new_value" type="text" size="9" value="{FEE_VALUE}"></div>
								<div class="col-md-2">
									<select name="new_type">
										<option value="flat"<!-- IF FEE_TYPE eq 'flat' --> selected<!-- ENDIF -->>{L_393}</option>
										<option value="perc"<!-- IF FEE_TYPE eq 'perc' --> selected<!-- ENDIF -->>{L_357}</option>
									</select>
								</div>
								<div class="col-md-2">&nbsp;</div>
							</div>
	<!-- ENDIF -->
						</div>
					</div>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<button class="btn btn-primary" type="submit" name="act">{L_530}</button>
				</form>
				<br>
<!-- ENDIF -->
				<div class="panel panel-default">
					<div class="panel-heading"><strong>{L_417}</strong></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-3"><a href="{SITEURL}admin/fees.php?type=signup_fee">{L_430}</a></div>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading"><strong>{L_431}</strong></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-3"><a href="{SITEURL}admin/fees.php?type=setup_fee">{L_432}</a></div>
							<div class="col-md-3"><a href="{SITEURL}admin/fees.php?type=featured_fee">{L_433}</a></div>
							<div class="col-md-3"><a href="{SITEURL}admin/fees.php?type=highlighted_fee">{L_434}</a></div>
							<div class="col-md-3"><a href="{SITEURL}admin/fees.php?type=picture_fee">{L_435}</a></div>
						</div>
						<div class="row">
							<div class="col-md-3"><a href="{SITEURL}admin/fees.php?type=buyer_fee">{L_775}</a></div>
							<div class="col-md-3"><a href="{SITEURL}admin/fees.php?type=subtitle_fee">{L_803}</a></div>
							<div class="col-md-3"><a href="{SITEURL}admin/fees.php?type=relist_fee">{L_437}</a></div>
							<div class="col-md-3"><a href="{SITEURL}admin/fees.php?type=bold_fee">{L_439}</a></div>
						</div>
						<div class="row">
							<div class="col-md-3"><a href="{SITEURL}admin/fees.php?type=reserve_fee">{L_440}</a></div>
							<div class="col-md-3"><a href="{SITEURL}admin/fees.php?type=buynow_fee">{L_436}</a></div>
							<div class="col-md-3"><a href="{SITEURL}admin/fees.php?type=endauc_fee">{L_791}</a></div>
							<div class="col-md-3"><a href="{SITEURL}admin/fees.php?type=extracat_fee">{L_804}</a></div>
						</div>
					</div>
				</div>
			</div>
		</div>
