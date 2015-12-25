<div class="content">
	<div class="tableContent2">
		<div class="titTable2">
			{L_001}
		</div>
<!-- IF B_FIRST -->
	<!-- IF ERROR ne '' -->
		<div class="error-box">
			{ERROR}
		</div>
	<!-- ENDIF -->
		<div class="table2">
			<form name="registration" action="{SSLURL}register.php" method="post">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<table width="90%" border="0" cellpadding="4" cellspacing="0">
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_002}</b> *</td>
						<td width="60%">
							<input type="text" name="TPL_name" <!-- IF MISSING0 eq 1 -->class="missing"<!-- ENDIF --> size=40 maxlength=255 value="{V_YNAME}" autofocus>
							<!-- IF MISSING0 eq 1 --><div class="error-box missing">{L_937}</div><!-- ENDIF -->
						</td>
					</tr>
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_003}</b> *</td>
						<td width="60%">
							<input type="text" name="TPL_nick" size=20 maxlength=20  value="{V_UNAME}" <!-- IF MISSING1 eq 1 -->class="missing"<!-- ENDIF -->> {L_050}
							<!-- IF MISSING1 eq 1 --><div class="error-box missing">{L_938}</div><!-- ENDIF -->
						</td>
					</tr>
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_004}</b> *</td>
						<td width="60%">
							<input type="password" name="TPL_password" size="20" <!-- IF MISSING2 eq 1 -->class="missing"<!-- ENDIF -->> {L_050}
							<!-- IF MISSING2 eq 1 --><div class="error-box missing">{L_939}</div><!-- ENDIF -->
						</td>
					</tr>
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_005}</b> *</td>
						<td width="60%">
							<input type="password" name="TPL_repeat_password" size="20" <!-- IF MISSING3 eq 1 -->class="missing"<!-- ENDIF -->>
							<!-- IF MISSING3 eq 1 --><div class="error-box missing">{L_940}</div><!-- ENDIF -->
						</td>
					</tr>
					<tr>
						<td width="40%"  valign="top" align="right"><b>{L_006}</b> *</td>
						<td width="60%">
							<input type="email" name="TPL_email" size="20" maxlength="50" value="{V_EMAIL}" <!-- IF MISSING4 eq 1 -->class="missing"<!-- ENDIF -->>
							<!-- IF MISSING4 eq 1 --><div class="error-box missing">{L_941}</div><!-- ENDIF -->
						</td>
					</tr>
		<!-- IF BIRTHDATE -->
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_252}</b>{REQUIRED(0)}</td>
						<td width="60%">
							{L_DATEFORMAT} <input type="text" name="TPL_year" size="4" maxlength="4" value="{V_YEAR}" <!-- IF MISSING5 eq 1 -->class="missing"<!-- ENDIF -->>
							<!-- IF MISSING5 eq 1 --><div class="error-box missing">{L_948}</div><!-- ENDIF -->
						</td>
					</tr>
		<!-- ENDIF -->
		<!-- IF ADDRESS -->
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_009}</b>{REQUIRED(1)}</td>
						<td width="60%">
							<input type="text" name="TPL_address" size="40" maxlength="255" value="{V_ADDRE}" <!-- IF MISSING6 eq 1 -->class="missing"<!-- ENDIF -->>
							<!-- IF MISSING6 eq 1 --><div class="error-box missing">{L_942}</div><!-- ENDIF -->
						</td>
					</tr>
		<!-- ENDIF -->
		<!-- IF CITY -->
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_010}</b>{REQUIRED(2)}</td>
						<td width="60%">
							<input type="text" name="TPL_city" size="25" maxlength="25" value="{V_CITY}" <!-- IF MISSING7 eq 1 -->class="missing"<!-- ENDIF -->>
							<!-- IF MISSING7 eq 1 --><div class="error-box missing">{L_943}</div><!-- ENDIF -->
						</td>
					</tr>
		<!-- ENDIF -->
		<!-- IF PROV -->
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_011}</b>{REQUIRED(3)}</td>
						<td width="60%">
							<input type="text" name="TPL_prov" size="20" maxlength="20" value="{V_PROV}" <!-- IF MISSING8 eq 1 -->class="missing"<!-- ENDIF -->>
							<!-- IF MISSING8 eq 1 --><div class="error-box missing">{L_944}</div><!-- ENDIF -->
						</td>
					</tr>
		<!-- ENDIF -->
		<!-- IF COUNTRY -->
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_014}</b>{REQUIRED(4)}</td>
						<td width="60%">
							<select name="TPL_country" <!-- IF MISSING9 eq 1 -->class="missing"<!-- ENDIF -->>
								<option value="">{L_251}</option>
								{L_COUNTRIES}
							</select>
							<!-- IF MISSING9 eq 1 --><div class="error-box missing">{L_945}</div><!-- ENDIF -->
						</td>
					</tr>
		<!-- ENDIF -->
		<!-- IF ZIP -->
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_012}</b>{REQUIRED(5)}</td>
						<td width="60%">
							<input type="text" name="TPL_zip" size="8" value="{V_POSTCODE}" <!-- IF MISSING10 eq 1 -->class="missing"<!-- ENDIF -->>
							<!-- IF MISSING10 eq 1 --><div class="error-box missing">{L_946}</div><!-- ENDIF -->
						</td>
					</tr>
		<!-- ENDIF -->
		<!-- IF TEL -->
					<tr>
						<td width="40%" valign="top" align="right"><b>{L_013}</b>{REQUIRED(6)}</td>
						<td width="60%">
							<input type="text" name="TPL_phone" size=40 maxlength=40 value="{V_PHONE}" <!-- IF MISSING11 eq 1 -->class="missing"<!-- ENDIF -->>
							<!-- IF MISSING11 eq 1 --><div class="error-box missing">{L_947}</div><!-- ENDIF -->
						</td>
					</tr>
		<!-- ENDIF -->
					<tr>
						<td valign="top" align="right">{L_346}</td>
						<td>
							{TIMEZONE}
						</td>
					</tr>
		<!-- IF B_NLETTER -->
					<tr>
						<td width="40%" align="right"><b>{L_608}</b></td>
						<td width="60%">
							<input type="radio" name="TPL_nletter" value="1" {V_YNEWSL}>
							{L_030}
							<input type="radio" name="TPL_nletter" value="2" {V_NNEWSL}>
							{L_029}
						</td>
					</tr>
		<!-- ENDIF -->
				</table>
				<table width="90%" border="0" cellpadding="4" cellspacing="0">
					<tr>
						<td width="40%" valign="top" align="right"></td>
						<td width="60%" ><h2>{L_719}</h2></td>
					</tr>
				<!-- IF B_PAYPAL -->
					<tr>
						<td align="right" width="30%">{L_720}{REQUIRED(7)}</td>
						<td>
							<input type="text" name="TPL_pp_email" size=40 value="{PP_EMAIL}" <!-- IF MISSING12 eq 1 -->class="missing"<!-- ENDIF -->>
							<!-- IF MISSING12 eq 1 --><div class="error-box missing">{L_810}</div><!-- ENDIF -->
						</td>
					</tr>
				<!-- ENDIF -->
				<!-- IF B_AUTHNET -->
					<tr>
						<td align="right" width="30%">{L_773}{REQUIRED(8)}</td>
						<td>
							<input type="text" name="TPL_authnet_id" size=40 value="{AN_ID}" <!-- IF MISSING13 eq 1 -->class="missing"<!-- ENDIF -->>
							<!-- IF MISSING13 eq 1 --><div class="error-box missing">{L_811}</div><!-- ENDIF -->
						</td>
					</tr>
					<tr>
						<td align="right" width="30%">{L_774}{REQUIRED(8)}</td>
						<td>
							<input type="text" name="TPL_authnet_pass" size=40 value="{AN_PASS}" <!-- IF MISSING13 eq 1 -->class="missing"<!-- ENDIF -->>
						</td>
					</tr>
				<!-- ENDIF -->
				<!-- IF B_WORLDPAY -->
					<tr>
						<td align="right" width="30%">{L_824}{REQUIRED(9)}</td>
						<td>
							<input type="text" name="TPL_worldpay_id" size=40 value="{WP_ID}" <!-- IF MISSING14 eq 1 -->class="missing"<!-- ENDIF -->>
							<!-- IF MISSING14 eq 1 --><div class="error-box missing">{L_823}</div><!-- ENDIF -->
						</td>
					</tr>
				<!-- ENDIF -->
				<!-- IF B_TOOCHECKOUT -->
					<tr>
						<td align="right" width="30%">{L_826}{REQUIRED(10)}</td>
						<td>
							<input type="text" name="TPL_toocheckout_id" size=40 value="{TC_ID}" <!-- IF MISSING15 eq 1 -->class="missing"<!-- ENDIF -->>
							<!-- IF MISSING15 eq 1 --><div class="error-box missing">{L_821}</div><!-- ENDIF -->
						</td>
					</tr>
				<!-- ENDIF -->
				<!-- IF B_MONEYBOOKERS -->
					<tr>
						<td align="right" width="30%">{L_825}{REQUIRED(11)}</td>
						<td>
							<input type="text" name="TPL_moneybookers_email" size=40 value="{MB_EMAIL}" <!-- IF MISSING16 eq 1 -->class="missing"<!-- ENDIF -->>
							<!-- IF MISSING16 eq 1 --><div class="error-box missing">{L_822}</div><!-- ENDIF -->
						</td>
					</tr>
				<!-- ENDIF -->
						<tr>
						<td colspan="2">{CAPCHA}</td>
					</tr>
				</table>
				<!-- IF B_FEES -->
				<div style="text-align:center">
					<p>{L_430}: {FEES}</p>
				</div>
				<!-- ENDIF -->
				<div style="text-align:center">
					<p><input type="checkbox" name="terms_check" id="terms_check"> {L_858}</p>
					<input type="hidden" name="action" value="first">
					<input type="submit" name="" value="{L_235}" class="button">
					<input type="reset" name="" value="{L_035}" class="button">
				</div>
			</form>
		</div>
<!-- ELSE -->
		<div class="padding">
			<h2>{L_HEADER}</h2>
			<p>{L_MESSAGE}</p>
			<p>{L_860}</p>
		</div>
<!-- ENDIF -->
	</div>
</div>