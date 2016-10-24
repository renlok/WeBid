				<div class="box">
					<h4 class="rounded-top">{L_25_0009}</h4>
					<div class="rounded-bottom">
						<ul class="menu">
							<li><a href="{SITEURL}admin/theme.php">{L_26_0002}</a></li>
							<li><a href="{SITEURL}admin/clearcache.php">{L_clear_cache}</a></li>
							<li><a href="{SITEURL}admin/clear_image_cache.php">{L_clear_image_cache}</a></li>
                        	<li><a href="{SITEURL}admin/logo_upload.php">{L_30_0215}</a></li>
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
