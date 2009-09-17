<html>
<head>
	<link rel="stylesheet" type="text/css" href="{SITEURL}admin/style.css">
</head>
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td background="{SITEURL}admin/images/bac_barint.gif">
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
			<tr>
				<td width="30"><img src="{SITEURL}admin/images/i_fee.gif" ></td>
				<td class="white">{L_25_0012}&nbsp;&gt;&gt;&nbsp;{L_25_0012}</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center" valign="middle">
		<table width="95%" border="0" cellpadding="1" bgcolor="#0083D7">
		<tr>
			<td align="center" class="title">{L_25_0012}</td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF">
                <form name="conf" action="" method="post">
				<table width="100%" cellpadding="2" align="center">
					<tr class="c3">
						<td colspan="2" bgcolor="#CCCCCC"><b>{L_417}</b></td>
					</tr>
					<tr class="c1">
						<td width="50%"><a href="{SITEURL}admin/fees.php?type=signup_fee">{L_430}</a></td>
						<td>&nbsp;</td>
					</tr>
					<tr class="c3">
						<td colspan="2" bgcolor="#CCCCCC"><b>{L_431}</b></td>
					</tr>
					<tr class="c1">
						<td width="50%"><a href="{SITEURL}admin/fees.php?type=setup">{L_432}</a> </td>
						<td><a href="{SITEURL}admin/fees.php?type=relist_fee">{L_437}</a> </td>
					</tr>
					<tr class="c2">
						<td width="50%"><a href="{SITEURL}admin/fees.php?type=hpfeat_fee">{L_433}</a> </td>
						<td><a href="{SITEURL}admin/fees.php?type=bolditem_fee">{L_439}</a> </td>
					</tr>
					<tr class="c1">
						<td width="50%"><a href="{SITEURL}admin/fees.php?type=hlitem_fee">{L_434}</a> </td>
						<td><a href="{SITEURL}admin/fees.php?type=rp_fee">{L_440}</a> </td>
					</tr>
					<tr class="c2">
						<td width="50%"><a href="{SITEURL}admin/fees.php?type=picture_fee">{L_435}</a> </td>
						<td width="50%"><a href="{SITEURL}admin/fees.php?type=buyout_fee">{L_436}</a> </td>
					</tr>
				</table>
			</td>
		</tr>
		</table>
		<br>
<!-- IF FEETYPE ne '' -->
		<table width="95%" border="0" cellpadding="1" bgcolor="#0083D7">
		<tr>
			<td align="center" class="title">{FEETYPE}</td>
		</tr>
		<tr>
			<td>
				<table width="100%" cellpadding="2" align="center" bgcolor="#FFFFFF">
	<!-- IF ERROR ne '' -->
					<tr bgcolor="yellow">
						<td class="error" colspan="6" align="center">{ERROR}</td>
					</tr>
	<!-- ENDIF -->
	<!-- IF B_SINGLE -->
					<tr valign="top">
						<td width="109" height="22">{L_263}</td>
						<td height="22" colspan="5">
							<input type="text" size="12" name="value" value="{VALUE}"> {CURRENCY}
						</td>
					</tr>
	<!-- ELSE -->
					<tr valign="top" bgcolor="#CCCCCC">
						<td width="120">&nbsp;</td>
						<td width="120"><b>{L_240} ({CURRENCY})</b></td>
						<td width="120"><b>{L_241} ({CURRENCY})</b></td>
						<td width="120"><b>{L_391} ({CURRENCY})</b></td>
						<td><b>{L_392}</td>
						<td width="70" align="center"><b>{L_008}</b></td>
					</tr>
		<!-- BEGIN fees -->
					<tr valign="top">
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
					<tr valign="top">
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
					<tr valign="top">
						<td height="22" colspan="6">&nbsp;</td>
					</tr>
					<tr>
						<td><input type="hidden" name="action" value="update"></td>
						<td colspan="5"><input type="submit" name="act" value="{L_530}"></td>
					</tr>
					<tr>
						<td colspan="6">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		</table>
<!-- ENDIF -->
		</form>
	</td>
</tr>
</table>

<!-- INCLUDE footer.tpl -->