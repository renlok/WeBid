		<div class="row">
			<div class="col-md-3">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
			<div class="col-md-9">
				<h4>{L_25_0009}&nbsp;&gt;&gt;&nbsp;{L_30_0215}</h4>
				<form name="logo" action="" method="post" enctype="multipart/form-data">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3">{L_your_logo}</div>
								<div class="col-md-9"><img src="{IMAGEURL}"></div>
							</div>
							<div class="row">
								<div class="col-md-3">{L_upload_new_logo}</div>
								<div class="col-md-9">
									<label class="btn btn-primary" for="logo">
										Browse <input id="logo" type="file" name="logo" style="display:none;">
									</label>
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<button class="btn btn-primary" type="submit" name="act">{L_30_0215}</button>
				</form>
			</div>
		</div>
