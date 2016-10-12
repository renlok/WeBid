		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0012}&nbsp;&gt;&gt;&nbsp;{L_1083}</h4>
				<form name="errorlog" action="" method="post">
				</form>
				<form name="tax_edit" action="" method="post">
					<table width="98%" cellpadding="0" cellspacing="0">
						<tr>
							<th><b>{L_1082}</b></th>
							<th><b>{L_1083}</b></th>
							<th><b>{L_1084}</b></th>
							<th><b>{L_1085}</b></th>
						</tr>
						<tr>
							<td><input type="text" name="tax_name" value="{TAX_NAME}"></td>
							<td><input type="text" name="tax_rate" value="{TAX_RATE}"> %</td>
							<td>
								<select name="seller_countries[]" multiple>
									{TAX_SELLER}
								</select>
							</td>
							<td>
								<select name="buyer_countries[]" multiple>
									{TAX_BUYER}
								</select>
							</td>
						</tr>
					</table>
					<input type="hidden" name="tax_id" value="{TAX_ID}">
					<input type="hidden" name="action" value="add">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_530}">
				</form>
				<form name="tax_update" action="" method="post">
					<table width="98%" cellpadding="0" cellspacing="0">
						<tr>
							<th><b>{L_1082}</b></th>
							<th><b>{L_1083}</b></th>
							<th><b>{L_1084}</b></th>
							<th><b>{L_1085}</b></th>
							<th><b>{L_1086}</b></th>
							<th>&nbsp;</th>
						</tr>
<!-- BEGIN tax_rates -->
						<tr>
							<td>{tax_rates.TAX_NAME}</td>
							<td>{tax_rates.TAX_RATE}%</td>
							<td>{tax_rates.TAX_SELLER}</td>
							<td>{tax_rates.TAX_BUYER}</td>
							<td><input type="radio" name="site_fee" value="{tax_rates.ID}"<!-- IF tax_rates.TAX_SITE_RATE eq 1 --> checked="checked"<!-- ENDIF -->></td>
							<td>
								<a href="tax_levels.php?id={tax_rates.ID}&type=edit">{L_298}</a><br>
								<a href="tax_levels.php?id={tax_rates.ID}&type=delete" onClick="return confirm('{L_1087}')">{L_008}</a>
							</td>
						</tr>
<!-- END tax_rates -->
					</table>
					<input type="hidden" name="action" value="sitefee">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_530}">
				</form>
			</div>
		</div>