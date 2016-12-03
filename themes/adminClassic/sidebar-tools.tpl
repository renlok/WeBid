				<div class="box">
					<h4 class="rounded-top">{L_5436}</h4>
					<div class="rounded-bottom">
						<ul class="menu">
							<li><a href="{SITEURL}admin/checkversion.php">{L_25_0169a}</a></li>
							<li><a href="{SITEURL}admin/maintenance.php">{L_maintenance_settings}</a></li>
							<li><a href="{SITEURL}admin/wordsfilter.php">{L_5068}</a></li>
							<li><a href="{SITEURL}admin/errorlog.php">{L_891}</a></li>
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
