				<ul class="list-group">
					<li class="list-group-item active">{L_25_0023}</li>
					<li class="list-group-item"><a href="{SITEURL}admin/stats_settings.php">{L_5142}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/viewaccessstats.php">{L_5143}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/viewbrowserstats.php">{L_5165}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/viewplatformstats.php">{L_5318}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/analytics.php">{L_analytics}</a></li>
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