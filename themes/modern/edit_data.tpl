<!-- INCLUDE user_menu_header.tpl -->
<div class="jumbotron">
	<h3>{NAME}<i> <span class="text-muted"><small>{NICK}</small></span></i></h3>
</div>
<form name="details" action="" method="post">
	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
	<div class="well">
		<div class="alert alert-info" role="alert">{L_617}</div>
		<div class="row">
			<div class="form-group col-lg-6">
				<label for="TPL_password">{L_004}</label>
				<input type="password" name="TPL_password" class="form-control" placeholder="{L_050}">
			</div>
			<div class="form-group col-lg-6">
				<label for="TPL_repeat_password">{L_005}</label>
				<input type="password" name="TPL_repeat_password" class="form-control" />
			</div>
			<div class="form-group col-lg-12">
				<label for="TPL_email">{L_006}</label>
				<input type="email" name="TPL_email" class="form-control" value="{EMAIL}">
			</div>
			<div class="form-group col-lg-12">
				<label for="TPL_year">{L_252}</label>
				<fieldset class="row">
					<div class="register-date col-md-8">{DATEFORMAT}</div>
					<div class="register-date col-md-4"> <input type="text" name="TPL_year" class="form-control" value="{YEAR}"></div>
				</fieldset>
			</div>
			<div class="form-group col-lg-6">
				<label for="TPL_address">{L_009}</label>
				<input type="text" name="TPL_address" class="form-control" value="{ADDRESS}">
			</div>
			<div class="form-group col-lg-6">
				<label for="TPL_city">{L_010}</label>
				<input type="text" name="TPL_city" class="form-control" value="{CITY}">
			</div>
			<div class="form-group col-lg-6">
				<label for="TPL_prov">{L_011}</label>
				<input type="text" name="TPL_prov" class="form-control" value="{PROV}">
			</div>
			<div class="form-group col-lg-6">
				<label for="TPL_country">{L_014}</label>
				<select name="TPL_country" class="form-control">
					{COUNTRYLIST}
				</select>
			</div>
			<div class="form-group col-lg-6">
				<label for="TPL_zip">{L_012}</label>
				<input type="text" name="TPL_zip" class="form-control" value="{ZIP}">
			</div>
			<div class="form-group col-lg-6">
				<label for="TPL_phone">{L_013}</label>
				<input type="text" name="TPL_phone" class="form-control" value="{PHONE}">
			</div>
			<div class="form-group col-lg-12">
				<label>{L_346}</label>
				<div class="timezone">
					{TIMEZONE}
				</div>
			</div>
		</div>
	</div>
	<div class="well">
		<div class="row">
			<div class="form-group col-lg-6">
				<label>{L_352}</label>
				<div class="radio">
					<label>
						<input type="radio" name="TPL_emailtype" value="html" {EMAILTYPE1} />
						{L_902}
					</label>
					<label>
						<input type="radio" name="TPL_emailtype" value="text" {EMAILTYPE2} />
						{L_915}
					</label>
				</div>
			</div>
<!-- IF B_NEWLETTER -->
			<div class="form-group col-lg-6">
				<label>{L_603}</label>
				<div class="radio">
					<label>
						<input type="radio" name="TPL_nletter" value="1" {NLETTER1} />
						{L_030}
					</label>
					<label>
						<input type="radio" name="TPL_nletter" value="2" {NLETTER2} />
						{L_029}
					</label>
				</div>
				<br>
				<div class="alert alert-info" role="alert">{L_609}</div>
			</div>
<!-- ENDIF -->
		</div>
	</div>
	<div class="well">
		<legend>
			{L_719}
		</legend>
		<div class="row">
			<div class="col-lg-6 col-md-6">
		<!-- BEGIN gateways -->
			<div class="form-group col-lg-12">
				<label for="{gateways.PLAIN_NAME}[address]">{gateways.ADDRESS_NAME}{gateways.REQUIRED}</label>
				<input type="hidden" name="{gateways.PLAIN_NAME}[id]" value="{gateways.GATEWAY_ID}">
				<input type="text" name="{gateways.PLAIN_NAME}[address]" class="form-control" value="{gateways.ADDRESS}">
			<!-- IF gateways.B_PASSWORD -->
				<label for="{gateways.PLAIN_NAME}[password]">{gateways.PASSWORD_NAME}{gateways.REQUIRED}</label>
				<input type="text" name="{gateways.PLAIN_NAME}[password]" class="form-control" value="{gateways.PASSWORD}">
			<!-- ELSE -->
				<input type="hidden" name="{gateways.PLAIN_NAME}[password]" value="">
			<!-- ENDIF -->
			</div>
		<!-- END gateways -->
			</div>
		</div>
	</div>
	<div class="text-center">
		<input type="submit" name="Input" value="{L_530}" class="btn btn-primary">
		<input type="reset" name="Input" class="btn btn-default">
	</div>
	<input type="hidden" name="action" value="update">
</form>

<!-- INCLUDE user_menu_footer.tpl -->
