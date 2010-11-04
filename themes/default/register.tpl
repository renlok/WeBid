<div class="content">
	<div class="tableContent2">
		<div class="titTable2">
			{L_001}
		</div>
<!-- IF B_FIRST -->
	<!-- IF ERROR ne '' -->
		<div class="errfont">
			{ERROR}
		</div>
	<!-- ENDIF -->
		<div class="table2">
			<form name="registration" action="{SSLURL}register.php" method="post">
				<table width="90%" border="0" cellpadding="4" cellspacing="0">
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_002}</b> *</td>
						<td width="60%">
							<input type="text" name="TPL_name" size=40 maxlength=255 value="{V_YNAME}">
						</td>
					</tr>
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_003}</b> *</td>
						<td width="60%">
							<input type="text" name="TPL_nick" size=20 maxlength=20  value="{V_UNAME}"> {L_050}
						</td>
					</tr>
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_004}</b> *</td>
						<td width="60%">
							<input type="password" name="TPL_password" size=20 maxlength=20 value=""> {L_050}
						</td>
					</tr>
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_005}</b> *</td>
						<td width="60%">
							<input type="password" name="TPL_repeat_password" size=20 maxlength=20 value="">
						</td>
					</tr>
					<tr>
						<td width="40%"  valign="top" align="right"><b>{L_006}</b> *</td>
						<td width="60%">
							<input type="text" name="TPL_email" size=50 maxlength=50 value="{V_EMAIL}">
						</td>
					</tr>
        <!-- IF BIRTHDATE -->
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_252}</b>{REQUIRED(0)}</td>
						<td width="60%">
							{L_DATEFORMAT} <input type="text" name="TPL_year" size="4" maxlength="4" value="{V_YEAR}">
						</td>
					</tr>
        <!-- ENDIF -->
        <!-- IF ADDRESS -->
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_009}</b>{REQUIRED(1)}</td>
						<td width="60%">
							<input type="text" name="TPL_address" size=40 maxlength=255 value="{V_ADDRE}">
						</td>
					</tr>
        <!-- ENDIF -->
        <!-- IF CITY -->
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_010}</b>{REQUIRED(2)}</td>
						<td width="60%">
							<input type="text" name="TPL_city" size=25 maxlength=25 value="{V_CITY}">
						</td>
					</tr>
        <!-- ENDIF -->
        <!-- IF PROV -->
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_011}</b>{REQUIRED(3)}</td>
						<td width="60%">
							<input type="text" name="TPL_prov" size=10 maxlength=10 value="{V_PROV}">
						</td>
					</tr>
        <!-- ENDIF -->
        <!-- IF COUNTRY -->
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_014}</b>{REQUIRED(4)}</td>
						<td width="60%">
							<select name="TPL_country">
								<option value="">{L_251}</option>
								{L_COUNTRIES}
							</select>
						</td>
					</tr>
        <!-- ENDIF -->
        <!-- IF ZIP -->
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_012}</b>{REQUIRED(5)}</td>
						<td width="60%">
							<input type="text" name="TPL_zip" size=8 value="{V_POSTCODE}">
						</td>
					</tr>
        <!-- ENDIF -->
        <!-- IF TEL -->
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_013}</b>{REQUIRED(6)}</td>
						<td width="60%">
							<input type="text" name="TPL_phone" size=40 maxlength=40 value="{V_PHONE}">
						</td>
					</tr>
        <!-- ENDIF -->
					<tr>
						<td valign="top" align="right">{L_346}</td>
						<td>
							{TOMEZONE}
						</td>
					</tr>
        <!-- IF B_NLETTER -->
					<tr>
						<td width="40%" align=right><b>{L_608}</b></td>
						<td width="60%">
							<input type="radio" name="TPL_nletter" value="1" {V_YNEWSL}>
							{L_030}
							<input type="radio" name="TPL_nletter" value="2" {V_NNEWSL}>
							{L_029}
						</td>
					</tr>
        <!-- ENDIF -->
				</table>

				<div class="padding">
					<h2>{L_719}</h2>
				</div>

				<table width="90%" border="0" cellpadding="4" cellspacing="0">
				<!-- IF B_PAYPAL -->
					<tr>
						<td align="right" width="30%">{L_720}{REQUIRED(7)}</td>
						<td>
							<input type="text" name="TPL_pp_email" size=40 value="{PP_EMAIL}">
						</td>
					</tr>
				<!-- ENDIF -->
				<!-- IF B_AUTHNET -->
					<tr>
						<td align="right" width="30%">{L_773}{REQUIRED(8)}</td>
						<td>
							<input type="text" name="TPL_authnet_id" size=40 value="{AN_ID}">
						</td>
					</tr>
					<tr>
						<td align="right" width="30%">{L_774}{REQUIRED(8)}</td>
						<td>
							<input type="text" name="TPL_authnet_pass" size=40 value="{AN_PASS}">
						</td>
					</tr>
				<!-- ENDIF -->
				<!-- IF B_WORLDPAY -->
					<tr>
						<td align="right" width="30%">{L_824}{REQUIRED(9)}</td>
						<td>
							<input type="text" name="TPL_worldpay_id" size=40 value="{WP_ID}">
						</td>
					</tr>
				<!-- ENDIF -->
				<!-- IF B_TOOCHECKOUT -->
					<tr>
						<td align="right" width="30%">{L_826}{REQUIRED(10)}</td>
						<td>
							<input type="text" name="TPL_toocheckout_id" size=40 value="{TC_ID}">
						</td>
					</tr>
				<!-- ENDIF -->
				<!-- IF B_MONEYBOOKERS -->
					<tr>
						<td align="right" width="30%">{L_825}{REQUIRED(11)}</td>
						<td>
							<input type="text" name="TPL_moneybookers_email" size=40 value="{MB_EMAIL}">
						</td>
					</tr>
				<!-- ENDIF -->
                    <tr>
						<td colspan="2">{CAPCHA}</td>
					</tr>
				</table>

				<div style="text-align:center">
					<!-- IF B_SHOWACCEPTANCE -->
					<p>{L_ACCEPTANCE}</p>
					<!-- ENDIF -->
					<input type="hidden" name="action" value="first">
					<input type="submit" name="" value="{L_235}" class="button">
					<input type="reset" name="" value="{L_035}" class="button">
				</div>
			</form>
		</div>
<!-- ELSE -->
		<div align="center">{L_MESSAGE}</div>
<!-- ENDIF -->
	</div>
</div>