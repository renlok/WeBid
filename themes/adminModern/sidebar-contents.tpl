				<ul class="list-group">
					<li class="list-group-item active">{L_25_0018}</li>
					<li class="list-group-item"><a href="{SITEURL}admin/news.php">{L_516}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/aboutus.php">{L_about_us_page}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/terms.php">{L_terms_conditions_page}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/privacypolicy.php">{L_privacy_policy}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/cookiespolicy.php">{L_cookie_policy}</a></li>
					<li class="list-group-item active">{L_5236}</li>
					<li class="list-group-item"><a href="{SITEURL}admin/faqscategories.php">{L_5230}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/newfaq.php">{L_5231}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/faqs.php">{L_5232}</a></li>
					<li class="list-group-item active">{L_5030}</li>
					<li class="list-group-item"><a href="{SITEURL}admin/boardsettings.php">{L_msg_board_settings}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/newboard.php">{L_5031}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/boards.php">{L_board_management}</a></li>
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
