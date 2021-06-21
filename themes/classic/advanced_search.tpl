<div class="content">
	<div class="titTable2 rounded-top rounded-bottom">
		{L_464}
	</div>
<!-- IF ERROR ne '' -->
	<div class="error-box">
		{ERROR}
	</div>
<!-- ENDIF -->
	<div class="table2">
		<form name="adsearch" method="post" action="">
			<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
			<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
				<tr>
					<td width="45%" align="right">{L_1000}</td>
					<td width="55%">
						<input type="search" size="45" name="title">
					</td>
				</tr>
				<tr>
					<td align="right">{L_1001}</td>
					<td>
						<input name="desc" type="checkbox" value="y">
					</td>
				</tr>
				<tr>
					<td align="right">{L_25_0214}</td>
					<td>
						<input name="closed" type="checkbox" id="closed" value="y">
					</td>
				</tr>
				<tr>
					<td align="right">{L_1002}</td>
					<td>{CATEGORY_LIST}</td>
				</tr>
				<tr>
					<td align="right">{L_1003}</td>
					<td>{L_1004}
						<input maxlength="12" name="minprice" size="5"> {CURRENCY}{L_1005} <input maxlength="12" name="maxprice" size="5"> {CURRENCY}
					</td>
				</tr>
				<tr valign="top">
					<td align="right">{L_2__0025}</td>
					<td>
						<input type="checkbox" name="buyitnow" value="y"> {L_30_0100}
						<input type="checkbox" name="buyitnowonly" value="y"> {L_30_0101}
					</td>
				</tr>
				<tr valign="top">
					<td align="right">{L_1006}</td>
					<td>{PAYMENTS_LIST}</td>
				</tr>
				<tr>
					<td align="right">{L_125}</td>
					<td>
						<input type="text" name="seller">
					</td>
				</tr>
				<tr>
					<td align="right">{L_448}</td>
					<td>
						<select name="adv[groups]">
						<option value="">{L_all_user_groups}</option>
						{USER_GROUP_LIST}
						</select>
					</td>
				</tr>
				<tr>
					<td align="right">{L_1008}</td>
					<td>{COUNTRY_LIST}</td>
				</tr>
				<tr>
					<td align="right">{L_012}</td>
					<td><input type="text" name="zipcode" size="12"></td>
				</tr>
				<tr>
					<td align="right">{L_1009}</td>
					<td>
						<select name="ending" size="1">
							<option></option>
							<option value="1">{L_1010}</option>
							<option value="2">{L_1011}</option>
							<option value="4">{L_1012}</option>
							<option value="6">{L_1013}</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right">{L_1014}</td>
					<td>
						<select name="SortProperty" size="1">
							<option></option>
							<option value="ends">{L_1015}</option>
							<option value="starts">{L_1016}</option>
							<option value="min_bid">{L_1017}</option>
							<option value="max_bid">{L_1018}</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right">{L_718}</td>
					<td>
						<select name="type" size="1">
							<option></option>
							<option value="2">{L_1020}</option>
							<option value="1">{L_1021}</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="center" colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td colspan=2 align="center">
						<input name="action" type="hidden" value="search">
						<input type="submit" name="go" value="{L_5029}" class="button">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
