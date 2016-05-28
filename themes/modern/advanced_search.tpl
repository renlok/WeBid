<div class="row">
	<div class="col-md-8 col-md-offset-2">
<!-- IF ERROR ne '' -->
		<div class="alert alert-danger" role="alert">
			{ERROR}
		</div>
<!-- ENDIF -->
		<div class="well">
			<legend>
				{L_464}
			</legend>
			<form class="form-horizontal" name="adsearch" method="post" action="">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<div class="form-group">
					<label class="col-sm-4 control-label">{L_1000}</label>
					<div class="col-sm-8">
						<input type="search" class="form-control" name="title">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">{L_1001}</label>
					<div class="col-sm-8">
						<div class="checkbox">
							<label><input name="desc" type="checkbox" value="y"></label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">{L_25_0214}</label>
					<div class="col-sm-8">
						<div class="checkbox">
							<label><input name="closed" type="checkbox" id="closed" value="y"></label>
						</div>
					</div>
				</div>
				<div class="form-group catsearch">
					<label class="col-sm-4 control-label">{L_1002}</label>
					<div class="col-sm-8">{CATEGORY_LIST}</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">{L_1003}</label>
					<div class="col-sm-8">
						<div class="row">
							<div class="col-sm-6">
								<div class="input-group">
									<input maxlength="12" name="minprice" class="form-control" placeholder="{L_1004}" aria-describedby="addonprice1">
									<span class="input-group-addon" id="addonprice1">{CURRENCY}</span>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="input-group">
									<input maxlength="12" name="maxprice" class="form-control" placeholder="{L_1005}" aria-describedby="addonprice1">
									<span class="input-group-addon" id="addonprice1">{CURRENCY}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">{L_2__0025}</label>
					<div class="col-sm-8">
						<div class="checkbox">
							<label><input type="checkbox" name="buyitnow" value="y"> {L_30_0100}</label>
							<label><input type="checkbox" name="buyitnowonly" value="y"> {L_30_0101}</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">{L_1006}</label>
					<div class="col-sm-8">
						<div class="checkbox">
							<label>{PAYMENTS_LIST}</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">{L_125}</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="seller">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">{L_448}</label>
					<div class="col-sm-8">
						<select name="adv[groups]" class="form-control">
							<option value="">{L_all_user_groups}</option>
							{USER_GROUP_LIST}
						</select>
					</div>
				</div>
				<div class="form-group locationsearch">
					<label class="col-sm-4 control-label">{L_1008}</label>
					<div class="col-sm-8">{COUNTRY_LIST}</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">{L_012}</label>
					<div class="col-sm-8">
						<input type="text" name="zipcode" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">{L_1009}</label>
					<div class="col-sm-8">
						<select name="ending" class="form-control">
							<option></option>
							<option value="1">{L_1010}</option>
							<option value="2">{L_1011}</option>
							<option value="4">{L_1012}</option>
							<option value="6">{L_1013}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">{L_1014}</label>
					<div class="col-sm-8">
						<select name="SortProperty" class="form-control">
							<option></option>
							<option value="ends">{L_1015}</option>
							<option value="starts">{L_1016}</option>
							<option value="min_bid">{L_1017}</option>
							<option value="max_bid">{L_1018}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">{L_718}</label>
					<div class="col-sm-8">
						<select name="type" class="form-control">
							<option></option>
							<option value="2">{L_1020}</option>
							<option value="1">{L_1021}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="text-center">
						<input name="action" type="hidden" value="search">
						<input type="submit" name="go" value="{L_5029}" class="btn btn-primary">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>