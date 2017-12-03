		<div class="row">
			<div class="col-md-3">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
			<div class="col-md-9">
				<h4>{L_25_0012}&nbsp;&gt;&gt;&nbsp;{L_1083}</h4>
				<form name="tax_edit" action="" method="post">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3"><strong>{L_1082}</strong></div>
								<div class="col-md-9"><input type="text" name="tax_name" value="{TAX_NAME}"></div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-3"><strong>{L_1083}</strong></div>
								<div class="col-md-9"><input type="text" name="tax_rate" value="{TAX_RATE}"> %</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-3"><strong>{L_1084}</strong></div>
								<div class="col-md-9">
									<select name="seller_countries[]" multiple>
										{TAX_SELLER}
									</select>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-3"><strong>{L_1085}</strong></div>
								<div class="col-md-9">
									<select name="buyer_countries[]" multiple>
										{TAX_BUYER}
									</select>
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" name="tax_id" value="{TAX_ID}">
					<input type="hidden" name="action" value="add">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<button class="btn btn-primary" type="submit" name="act">{L_530}</button>
				</form>
				<br>
				<form name="tax_update" action="" method="post">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-2"><strong>{L_1082}</strong></div>
								<div class="col-md-2"><strong>{L_1083}</strong></div>
								<div class="col-md-2"><strong>{L_1084}</strong></div>
								<div class="col-md-2"><strong>{L_1085}</strong></div>
								<div class="col-md-2"><strong>{L_1086}</strong></div>
								<div class="col-md-2"><strong>&nbsp;</strong></div>
							</div>
<!-- BEGIN tax_rates -->
							<div class="row">
								<div class="col-md-2">{tax_rates.TAX_NAME}</div>
								<div class="col-md-2">{tax_rates.TAX_RATE}%</div>
								<div class="col-md-2">{tax_rates.TAX_SELLER}</div>
								<div class="col-md-2">{tax_rates.TAX_BUYER}</div>
								<div class="col-md-2">
									<input type="radio" name="site_fee" value="{tax_rates.ID}"<!-- IF tax_rates.TAX_SITE_RATE eq 1 --> checked="checked"<!-- ENDIF -->>
								</div>
								<div class="col-md-2">
									<a href="tax_levels.php?id={tax_rates.ID}&type=edit">{L_298}</a><br>
									<a href="tax_levels.php?id={tax_rates.ID}&type=delete" onClick="return confirm('{L_1087}')">{L_008}</a>
								</div>
							</div>
<!-- END tax_rates -->
						</div>
					</div>
					<input type="hidden" name="action" value="sitefee">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<button class="btn btn-primary" type="submit" name="act">{L_530}</button>
				</form>
			</div>
		</div>
