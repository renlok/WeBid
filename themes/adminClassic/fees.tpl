		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_25_0012}&nbsp;&gt;&gt;&nbsp;{L_842}</h4>
				<form name="errorlog" action="" method="post">
<!-- IF FEETYPE ne '' -->
					<table width="98%" cellpadding="0" cellspacing="0">
						<tr>
							<th colspan="6">{FEETYPE}</th>
						</tr>
	<!-- IF B_SINGLE -->
						<tr>
							<td width="109" height="22">{L_263}</td>
							<td height="22" colspan="5">
								<input type="text" size="12" name="value" value="{VALUE}"> {CURRENCY}
							</td>
						</tr>
	<!-- ELSE -->
						<tr>
							<th width="120">&nbsp;</th>
							<th width="120"><b>{L_240} ({CURRENCY})</b></th>
							<th width="120"><b>{L_241} ({CURRENCY})</b></th>
							<th width="120"><b>{L_391} ({CURRENCY})</b></th>
							<th><b>{L_392}</b></th>
							<th width="70" align="center"><b>{L_008}</b></th>
						</tr>
		<!-- BEGIN fees -->
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="hidden" name="tier_id[]" value="{fees.ID}">
								<input name="fee_from[]" type="text" value="{fees.FROM}" size="9">
							</td>
							<td><input name="fee_to[]" type="text" value="{fees.TO}" size="9"></td>
							<td><input name="value[]" type="text" value="{fees.VALUE}" size="9"></td>
							<td>
								<select name="type[]">
									<option value="flat"{fees.FLATTYPE}>{L_393}</option>
									<option value="perc"{fees.PERCTYPE}>{L_357}</option>
								</select>
							</td>
							<td align="center"><input type="checkbox" name="fee_delete[]" value="{fees.ID}"></td>
						</tr>
		<!-- END fees -->
						<tr>
							<td>{L_394}</td>
							<td><input name="new_fee_from" type="text" size="9" value="{FEE_FROM}"></td>
							<td><input name="new_fee_to" type="text" size="9" value="{FEE_TO}"></td>
							<td><input name="new_value" type="text" size="9" value="{FEE_VALUE}"></td>
							<td>
								<select name="new_type">
									<option value="flat"<!-- IF FEE_TYPE eq 'flat' --> selected<!-- ENDIF -->>{L_393}</option>
									<option value="perc"<!-- IF FEE_TYPE eq 'perc' --> selected<!-- ENDIF -->>{L_357}</option>
								</select>
							</td>
							<td>&nbsp;</td>
						</tr>
	<!-- ENDIF -->
					</table>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_530}">
					<div class="plain-box">&nbsp;</div>
<!-- ENDIF -->
					<table width="98%" cellpadding="0" cellspacing="0">
						<tr>
							<th colspan="2"><b>{L_417}</b></th>
						</tr>
						<tr>
							<td width="50%"><a href="{SITEURL}admin/fees.php?type=signup_fee">{L_430}</a></td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<th colspan="2"><b>{L_431}</b></th>
						</tr>
						<tr>
							<td><a href="{SITEURL}admin/fees.php?type=setup_fee">{L_432}</a> </td>
							<td><a href="{SITEURL}admin/fees.php?type=relist_fee">{L_437}</a> </td>
						</tr>
						<tr>
							<td><a href="{SITEURL}admin/fees.php?type=featured_fee">{L_433}</a> </td>
							<td><a href="{SITEURL}admin/fees.php?type=bold_fee">{L_439}</a> </td>
						</tr>
						<tr>
							<td><a href="{SITEURL}admin/fees.php?type=highlighted_fee">{L_434}</a> </td>
							<td><a href="{SITEURL}admin/fees.php?type=reserve_fee">{L_440}</a> </td>
						</tr>
						<tr>
							<td><a href="{SITEURL}admin/fees.php?type=picture_fee">{L_435}</a> </td>
							<td><a href="{SITEURL}admin/fees.php?type=buynow_fee">{L_436}</a> </td>
						</tr>
						<tr>
							<td><a href="{SITEURL}admin/fees.php?type=buyer_fee">{L_775}</a></td>
							<td><a href="{SITEURL}admin/fees.php?type=endauc_fee">{L_791}</a></td>
						</tr>
						<tr>
							<td><a href="{SITEURL}admin/fees.php?type=subtitle_fee">{L_803}</a></td>
							<td><a href="{SITEURL}admin/fees.php?type=extracat_fee">{L_804}</a></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
