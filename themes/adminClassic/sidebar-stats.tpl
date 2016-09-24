				<div class="box">
					<h4 class="rounded-top">{L_25_0023}</h4>
					<div class="rounded-bottom">
						<ul class="menu">
							<li><a href="{SITEURL}admin/stats_settings.php">{L_5142}</a></li>
							<li><a href="{SITEURL}admin/viewaccessstats.php">{L_5143}</a></li>
							<li><a href="{SITEURL}admin/viewbrowserstats.php">{L_5165}</a></li>
							<li><a href="{SITEURL}admin/viewplatformstats.php">{L_5318}</a></li>
							<li><a href="{SITEURL}admin/analytics.php">{L_analytics}</a></li>
						</ul>
					</div>
				</div>
				<div class="box">
					<h4 class="rounded-top">{L_1061}</h4>
					<div class="rounded-bottom">
						<form name="anotes" action="" method="post">
							<textarea rows="15" name="anotes" class="anotes">{ADMIN_NOTES}</textarea>
							<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
							<input type="submit" name="act" value="{L_submit}">
						</form>
					</div>
				</div>