<div class="row">
	<div class="col-md-12">
<!-- IF B_FIRST -->
	<!-- IF ERROR ne '' -->
		<div class="alert alert-danger">
			{ERROR}
		</div>
	<!-- ENDIF -->
		<form name="registration" action="{SSLURL}register.php" method="post">
			<div class="col-md-7 well">
				<legend>{L_001}</legend>
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<div class="form-group col-lg-6 <!-- IF MISSING0 eq 1 -->has-error<!-- ENDIF -->">
					<label for="TPL_name">{L_002} *</label>
					<input type="text" class="form-control" name="TPL_name" <!-- IF MISSING0 eq 1 -->id="inputError1"<!-- ENDIF --> value="{V_YNAME}">
					<!-- IF MISSING0 eq 1 --><div class="error-box missing">{L_937}</div><!-- ENDIF -->
				</div>
				<div class="form-group col-lg-6 <!-- IF MISSING1 eq 1 -->has-error<!-- ENDIF -->">
					<label for="TPL_nick">{L_003} *</label>
					<input type="text" name="TPL_nick" class="form-control"  value="{V_UNAME}" <!-- IF MISSING1 eq 1 -->id="inputError1"<!-- ENDIF --> placeholder="{L_050}">
					<!-- IF MISSING1 eq 1 --><div class="error-box missing">{L_938}</div><!-- ENDIF -->
				</div>
				<div class="col-lg-12"></div>
				<div class="form-group col-lg-6 <!-- IF MISSING2 eq 1 -->has-error<!-- ENDIF -->">
					<label for="TPL_password">{L_004} *</label>
					<input type="password" name="TPL_password" class="form-control" <!-- IF MISSING2 eq 1 -->id="inputError1"<!-- ENDIF --> placeholder="{L_050}">
					<!-- IF MISSING2 eq 1 --><div class="error-box missing">{L_939}</div><!-- ENDIF -->
				</div>
				<div class="form-group col-lg-6 <!-- IF MISSING3 eq 1 -->has-error<!-- ENDIF -->">
					<label for="TPL_repeat_password">{L_005} *</label>
					<input type="password" name="TPL_repeat_password" class="form-control" <!-- IF MISSING3 eq 1 -->id="inputError1"<!-- ENDIF -->>
					<!-- IF MISSING3 eq 1 --><div class="error-box missing">{L_940}</div><!-- ENDIF -->
				</div>
				<div class="col-lg-12"></div>
				<div class="form-group col-lg-12 <!-- IF MISSING4 eq 1 -->has-error<!-- ENDIF -->">
					<label for="TPL_email">{L_006} *</label>
					<input type="email" name="TPL_email" class="form-control" value="{V_EMAIL}" <!-- IF MISSING4 eq 1 -->id="inputError1"<!-- ENDIF -->>
					<!-- IF MISSING4 eq 1 --><div class="error-box missing">{L_941}</div><!-- ENDIF -->
				</div>
	<!-- IF BIRTHDATE -->
				<div class="form-group col-lg-12 <!-- IF MISSING5 eq 1 -->has-error<!-- ENDIF -->">
					<label for="TPL_year">{L_252}{REQUIRED(0)}</label>
					<fieldset class="row">
						<div class="register-date col-md-8">{L_DATEFORMAT}</div> <div class="register-date col-md-4"><input type="text" name="TPL_year" class="form-control" value="{V_YEAR}" <!-- IF MISSING5 eq 1 -->id="inputError1"<!-- ENDIF -->></div>
					</fieldset>
					<!-- IF MISSING5 eq 1 --><div class="error-box missing">{L_948}</div><!-- ENDIF -->
				</div>
	<!-- ENDIF -->
				<div class="col-lg-12"></div>
	<!-- IF ADDRESS -->
				<div class="form-group col-lg-6 <!-- IF MISSING6 eq 1 -->has-error<!-- ENDIF -->">
					<label for="TPL_address">{L_009}{REQUIRED(1)}</label>
					<input type="text" name="TPL_address" class="form-control" value="{V_ADDRE}" <!-- IF MISSING6 eq 1 -->id="inputError1"<!-- ENDIF -->>
					<!-- IF MISSING6 eq 1 --><div class="error-box missing">{L_942}</div><!-- ENDIF -->
				</div>
	<!-- ENDIF -->
	<!-- IF CITY -->
				<div class="form-group col-lg-6 <!-- IF MISSING7 eq 1 -->has-error<!-- ENDIF -->">
					<label for="TPL_city">{L_010}{REQUIRED(2)}</label>
					<input type="text" name="TPL_city" class="form-control" value="{V_CITY}" <!-- IF MISSING7 eq 1 -->id="inputError1"<!-- ENDIF -->>
					<!-- IF MISSING7 eq 1 --><div class="error-box missing">{L_943}</div><!-- ENDIF -->
				</div>
	<!-- ENDIF -->
				<div class="col-lg-12"></div>

	<!-- IF PROV -->
				<div class="form-group col-lg-6 <!-- IF MISSING8 eq 1 -->has-error<!-- ENDIF -->">
					<label for="TPL_prov">{L_011}{REQUIRED(3)}</label>
					<input type="text" name="TPL_prov" class="form-control" value="{V_PROV}" <!-- IF MISSING8 eq 1 -->id="inputError1"<!-- ENDIF -->>
					<!-- IF MISSING8 eq 1 --><div class="error-box missing">{L_944}</div><!-- ENDIF -->
				</div>
	<!-- ENDIF -->
	<!-- IF COUNTRY -->
				<div class="form-group col-lg-6 <!-- IF MISSING9 eq 1 -->has-error<!-- ENDIF -->">
					<label for="TPL_country">{L_014}{REQUIRED(4)}</label>
					<select name="TPL_country" class="form-control" <!-- IF MISSING9 eq 1 -->id="inputError1"<!-- ENDIF -->>
						<option value="">{L_251}</option>
						{L_COUNTRIES}
					</select>
					<!-- IF MISSING9 eq 1 --><div class="error-box missing">{L_945}</div><!-- ENDIF -->
				</div>
	<!-- ENDIF -->
				<div class="col-lg-12"></div>
	<!-- IF ZIP -->
				<div class="form-group col-lg-6 <!-- IF MISSING10 eq 1 -->has-error<!-- ENDIF -->">
					<label for="TPL_zip">{L_012}{REQUIRED(5)}</label>
					<input type="text" name="TPL_zip" class="form-control" value="{V_POSTCODE}" <!-- IF MISSING10 eq 1 -->id="inputError1"<!-- ENDIF -->>
					<!-- IF MISSING10 eq 1 --><div class="error-box missing">{L_946}</div><!-- ENDIF -->
				</div>
	<!-- ENDIF -->
	<!-- IF TEL -->
				<div class="form-group col-lg-6 <!-- IF MISSING11 eq 1 -->has-error<!-- ENDIF -->">
					<label for="TPL_phone">{L_013}{REQUIRED(6)}</label>
					<input type="text" name="TPL_phone" class="form-control" value="{V_PHONE}" <!-- IF MISSING11 eq 1 -->id="inputError1"<!-- ENDIF -->>
					<!-- IF MISSING11 eq 1 --><div class="error-box missing">{L_947}</div><!-- ENDIF -->
				</div>
	<!-- ENDIF -->
				<div class="col-lg-12"></div>
				<div class="form-group col-lg-12">
					<label>{L_346}</label>
					<div class="timezone">
						{TIMEZONE}
					</div>
				</div>
	<!-- IF B_NLETTER -->
				<div class="form-group col-lg-12">
					<div class="alert alert-info" role="alert">
						<label>{L_608}</label>
						<label class="checkbox-inline"><input type="radio" name="TPL_nletter" value="1" {V_YNEWSL}>{L_030}</label>
						<label class="checkbox-inline"><input type="radio" name="TPL_nletter" value="2" {V_NNEWSL}>{L_029}</label>
					</div>
				</div>
	<!-- ENDIF -->
			</div>
			<div class="col-md-4 col-md-offset-1 well">
				<legend>{L_719}</legend>
	<!-- IF B_PAYPAL -->
				<div class="form-group <!-- IF MISSING12 eq 1 -->has-error<!-- ENDIF --> col-lg-12">
					<label for="TPL_pp_email">{L_720}{REQUIRED(7)}</label>
					<input type="text" name="TPL_pp_email" class="form-control" value="{PP_EMAIL}" <!-- IF MISSING12 eq 1 -->id="inputError1"<!-- ENDIF -->>
					<!-- IF MISSING12 eq 1 --><div class="error-box missing">{L_810}</div><!-- ENDIF -->
				</div>
	<!-- ENDIF -->
	<!-- IF B_AUTHNET -->
				<div class="form-group <!-- IF MISSING13 eq 1 -->has-error<!-- ENDIF --> col-lg-12">
					<label for="TPL_authnet_id">{L_773}{REQUIRED(8)}</label>
					<input type="text" name="TPL_authnet_id" class="form-control" value="{AN_ID}" <!-- IF MISSING13 eq 1 -->id="inputError1"<!-- ENDIF -->>
					<!-- IF MISSING13 eq 1 --><div class="error-box missing">{L_811}</div><!-- ENDIF -->
					<label for="TPL_authnet_pass">{L_774}{REQUIRED(8)}</label>
					<input type="text" name="TPL_authnet_pass" class="form-control" value="{AN_PASS}" <!-- IF MISSING13 eq 1 -->id="inputError1"<!-- ENDIF -->>
				</div>
	<!-- ENDIF -->
	<!-- IF B_WORLDPAY -->
				<div class="form-group <!-- IF MISSING14 eq 1 -->has-error<!-- ENDIF --> col-lg-12">
					<label for="TPL_worldpay_id">{L_824}{REQUIRED(9)}</label>
					<input type="text" name="TPL_worldpay_id" class="form-control" value="{WP_ID}" <!-- IF MISSING14 eq 1 -->id="inputError1"<!-- ENDIF -->>
					<!-- IF MISSING14 eq 1 --><div class="error-box missing">{L_823}</div><!-- ENDIF -->
				</div>
	<!-- ENDIF -->
	<!-- IF B_TOOCHECKOUT -->
				<div class="form-group <!-- IF MISSING15 eq 1 -->has-error<!-- ENDIF --> col-lg-12">
					<label for="TPL_toocheckout_id">{L_826}{REQUIRED(10)}</label>
					<input type="text" name="TPL_toocheckout_id" class="form-control" value="{TC_ID}" <!-- IF MISSING15 eq 1 -->class="missing"<!-- ENDIF -->>
					<!-- IF MISSING15 eq 1 --><div class="error-box missing">{L_821}</div><!-- ENDIF -->
				</div>
	<!-- ENDIF -->
	<!-- IF B_MONEYBOOKERS -->
				<div class="form-group <!-- IF MISSING16 eq 1 -->has-error<!-- ENDIF --> col-lg-12">
					<label for="TPL_moneybookers_email">{L_825}{REQUIRED(11)}</label>
					<input type="text" name="TPL_moneybookers_email" class="form-control" value="{MB_EMAIL}" <!-- IF MISSING16 eq 1 -->class="missing"<!-- ENDIF -->>
					<!-- IF MISSING16 eq 1 --><div class="error-box missing">{L_822}</div><!-- ENDIF -->
				</div>
	<!-- ENDIF -->
				<div class="form-group col-lg-12">
					<div class="capchabox">{CAPCHA}</div>
				</div>
				<div class="form-group col-lg-12">
					<div class="checkbox">
						<label>
							<input type="checkbox" name="terms_check" id="terms_check"> {L_858}
						</label>
					</div>
					<br><br>
					<div class="text-center">
						<input type="hidden" name="action" value="first">
						<input type="submit" name="" value="{L_235}" class="btn btn-primary">
						<input type="reset" name="" value="{L_035}" class="btn btn-default">
					</div>
				</div>
			</div>
		</form>
<!-- ELSE -->
		<div class="well">
			<h2>{L_HEADER}</h2>
			<p>{L_MESSAGE}</p>
			<p>{L_860}</p>
		</div>
<!-- ENDIF -->
	</div>
</div>