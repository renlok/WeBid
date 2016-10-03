				<ul class="list-group">
					<li class="list-group-item active">{L_25_0011}</li>
					<li class="list-group-item"><a href="{SITEURL}admin/banners.php">{L_5205}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/managebanners.php">{L_banner_admin}</a></li>
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