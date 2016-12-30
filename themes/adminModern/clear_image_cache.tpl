		<div class="row">
			<div class="col-md-3">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
			<div class="col-md-9">
				<h4>{L_25_0009}&nbsp;&gt;&gt;&nbsp;{L_clear_image_cache}</h4>
				<form name="errorlog" action="" method="post">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">{L_clear_image_cache_explain}</div>
							</div>
						</div>
					</div>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<button class="btn btn-primary" type="submit" name="act">{L_clear_image_cache}</button>
				</form>
			</div>
		</div>
