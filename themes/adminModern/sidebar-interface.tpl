				<ul class="list-group">
					<li class="list-group-item active">{L_25_0009}</li>
					<li class="list-group-item"><a href="{SITEURL}admin/theme.php">{L_26_0002}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/clearcache.php">{L_clear_cache}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/clear_image_cache.php">{L_clear_image_cache}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/logo_upload.php">{L_30_0215}</a></li>
				</ul>
				<div class="panel panel-default">
					<div class="panel-heading">{L_1061}</div>
					<div class="panel-body">
						<form name="anotes" action="" method="post">
							<textarea rows="15" name="anotes" class="form-control">{ADMIN_NOTES}</textarea>
							<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
							<br>
							<button class="btn btn-primary" type="submit" name="act">{L_submit}</button>
						</form>
					</div>
				</div>
