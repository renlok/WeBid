<div class="row">
	<div class="col-md-12">
		<div class="col-md-6 col-md-offset-3 well">
			<legend>{L_215}</legend>
<!-- IF B_FIRST -->
	<!-- IF ERROR ne '' -->
			<div class="alert alert-danger">
				{ERROR}
			</div>
	<!-- ENDIF -->
			<form name="user_login" action="" method="post">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<div class="form-group col-md-8 col-md-offset-2">
					<div class="alert alert-info" role="alert">{L_2__0039}</div>
				</div>
				<div class="form-group col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></span>
						<input type="text" NAME="TPL_username" class="form-control" placeholder="{L_username}" value="{USERNAME}">
					</div>
					<br>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">@</span>
						<input type="text" NAME="TPL_email" class="form-control" placeholder="{L_006}" value="{EMAIL}">
					</div>
				</div>
				<div class="clearfix"></div>
				<input type="submit" name="" value="{L_5431}" class="btn btn-primary center-block">
				<input type="hidden" name="action" value="ok">
			</form>
<!-- ELSE -->
			{L_217}
<!-- ENDIF -->
		</div>
	</div>
</div>