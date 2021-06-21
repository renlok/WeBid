<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well">
			<legend>{L_181}</legend>
<!-- IF ERROR ne '' -->
			<div class="alert alert-danger">
				{ERROR}
			</div>
<!-- ENDIF -->
			<div class="col-md-5">
				<h2>{L_862}</h2>
				<form name="user_login" action="{SITEURL}user_login.php" method="post">
					<div class="form-group col-md-10">
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></span>
							<input type="text" autofocus name="username" class="form-control" placeholder="{L_187}" value="{USER}">
						</div>
						<br>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
							<input type="password" name="password" class="form-control" placeholder="{L_004}" value="">
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="form-group col-md-10">
						<input type="submit" name="input" value="Login" class="btn btn-primary">
						<input type="hidden" name="action" value="login">
						<div class="pull-right">
							<input type="checkbox" name="rememberme" value="1">&nbsp;{L_25_0085}
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="form-group col-md-10">
						<a href="forgotpasswd.php">{L_215}</a>
					</div>
					<div class="clearfix"></div>
				</form>
			</div>
			<div class="col-md-2 hidden-xs">
				<h2 class="or"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span></h2>
			</div>
			<div class="col-md-5 hidden-xs">
				{L_863}
			</div>
		</div>
	</div>
</div>