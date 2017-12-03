<div class="row">
	<div class="col-md-12">
<!-- IF B_FIRST -->
	<!-- IF ERROR ne '' -->
		<div class="alert alert-danger">
			{ERROR}
		</div>
	<!-- ENDIF -->
		<form name="registration" action="{SITEURL}register.php" method="post">
			<div class="col-md-12 well">
				<legend>{L_001}</legend>
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<div class="form-group col-lg-6 <!-- IF MISSING0 eq 1 -->has-error<!-- ENDIF -->">
					<label for="TPL_name">{L_002} *</label>
					<input type="text" class="form-control" name="TPL_name" <!-- IF MISSING0 eq 1 -->id="inputError1"<!-- ENDIF --> value="{V_YNAME}" autofocus>
					<!-- IF MISSING0 eq 1 --><div class="error-box missing">{L_937}</div><!-- ENDIF -->
				</div>
				<div class="form-group col-lg-6 <!-- IF MISSING1 eq 1 -->has-error<!-- ENDIF -->">
					<label for="TPL_nick">{L_username} *</label>
					<input type="text" name="TPL_nick" class="form-control"  value="{V_UNAME}" <!-- IF MISSING1 eq 1 -->id="inputError1"<!-- ENDIF --> placeholder="{L_050}">
					<!-- IF MISSING1 eq 1 --><div class="error-box missing">{L_938}</div><!-- ENDIF -->
				</div>
				<div class="col-lg-12"></div>
				<div class="form-group col-lg-6 <!-- IF MISSING2 eq 1 -->has-error<!-- ENDIF -->">
					<label for="TPL_password">{L_password} *</label>
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
						<label class="checkbox-inline"><input type="radio" name="TPL_nletter" value="1" {V_YNEWSL}>{L_yes}</label>
						<label class="checkbox-inline"><input type="radio" name="TPL_nletter" value="2" {V_NNEWSL}>{L_no}</label>
					</div>
				</div>
	<!-- ENDIF -->

				<legend>{L_719}</legend>

	<!-- BEGIN gateways -->
		<div class="form-group col-lg-12">
			<label for="TPL_pp_email">{gateways.ADDRESS_NAME}{gateways.REQUIRED}</label>
			<input type="hidden" name="{gateways.PLAIN_NAME}[id]" value="{gateways.GATEWAY_ID}">
			<input type="text" name="{gateways.PLAIN_NAME}[address]" class="form-control" value="{gateways.ADDRESS}" <!-- IF gateways.MISSING eq 1 -->id="inputError1"<!-- ENDIF -->>
			<!-- IF gateways.MISSING eq 1 --><div class="error-box missing">{gateways.ERROR_STRING}</div><!-- ENDIF -->
		<!-- IF gateways.B_PASSWORD -->
			<label for="TPL_authnet_pass">{gateways.PASSWORD_NAME}{gateways.REQUIRED}</label>
			<input type="text" name="{gateways.PLAIN_NAME}[password]" class="form-control" value="{gateways.PASS}" <!-- IF gateways.MISSING eq 1 -->id="inputError1"<!-- ENDIF -->>
		<!-- ELSE -->
			<input type="hidden" name="{gateways.PLAIN_NAME}[password]" value="">
		<!-- ENDIF -->
		</div>
	<!-- END gateways -->
				<div class="form-group col-lg-12">
					<div class="capchabox">{CAPCHA}</div>
				</div>
				<div class="form-group col-lg-12">
					<div class="text-center">
						<div class="checkbox">
							<label><input type="checkbox" name="terms_check" id="terms_check"> {L_858}</label>
						</div>
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
