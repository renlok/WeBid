<div class="row">
	<div class="col-md-12">
		<div class="col-md-8 col-md-offset-2 well">
			<legend>{L_248}</legend>

<!-- IF PAGE eq 'error' -->
			<div class="alert alert-danger" role="alert">
				{ERROR}
			</div>
<!-- ELSEIF PAGE eq 'confirm' -->
			<form name="registration" action="{SITEURL}confirm.php" method="post">
				<p>{L_267}</p>
				<input type="hidden" name="id" value="{USERID}">
				<input type="hidden" name="hash" value="{HASH}">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<button class="btn btn-primary" type="submit" name="action" value="Confirm">{L_249}</button>
				<button class="btn btn-danger" type="submit" name="action" value="Refuse">{L_250}</button>
			</form>
<!-- ELSEIF PAGE eq 'confirmed' -->
			{L_330}
<!-- ELSEIF PAGE eq 'refused' -->
			{L_331}
<!-- ENDIF -->
		</div>
	</div>
</div>