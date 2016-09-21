				<ul class="list-group">
					<li class="list-group-item active">{L_239}</li>
					<li class="list-group-item"><a href="{SITEURL}admin/listauctions.php">{L_067}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/listclosedauctions.php">{L_214}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/listreportedauctions.php">{L_view_reported_auctions}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/listsuspendedauctions.php">{L_5227}</a></li>
					<li class="list-group-item"><a href="searchauctions.php">{L_067a}</a></li>
				</ul>
				<ul class="list-group">
					<li class="list-group-item active">{L_moderation}</li>
					<li class="list-group-item"><a href="{SITEURL}admin/moderateauctions.php">{L_moderation_queue}</a></li>
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