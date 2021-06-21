				<ul class="list-group">
					<li class="list-group-item active">{L_25_0010}</li>
					<li class="list-group-item"><a href="{SITEURL}admin/listusers.php">{L_045}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/newuser.php">{L__0026}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/usergroups.php">{L_448}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/profile.php">{L_048}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/activatenewsletter.php">{L_25_0079}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/newsletter.php">{L_607}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/banips.php">{L_2_0017}</a></li>
					<li class="list-group-item active">{L_365}</li>
					<li class="list-group-item"><a href="{SITEURL}admin/newadminuser.php">{L_367}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/adminusers.php">{L_525}</a></li>
				</ul>
				<div class="panel panel-default">
					<div class="panel-heading">{L_1061}</div>
					<div class="panel-body">
						<form name="anotes" action="" method="post">
							<textarea rows="15" name="anotes" class="form-control">{ADMIN_NOTES}</textarea>
							<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
							<br>
							<button class="btn btn-primary" type="submit" name="act">{L_007}</button>
						</form>
					</div>
				</div>
