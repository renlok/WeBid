		<div class="row">
			<div class="col-md-3">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
			<div class="col-md-9">
				<h2>{L_25_0011}&nbsp;&gt;&gt;&nbsp;{L__0008}</h2>
				<form name="deleteusers" action="" method="post">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12"><a href="newbannersuser.php">{L__0026}</a></div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-2"><strong>{L_5180}</strong></div>
								<div class="col-md-3"><strong>{L__0022}</strong></div>
								<div class="col-md-3"><strong>{L_303}</strong></div>
								<div class="col-md-1"><strong>{L__0025}</strong></div>
								<div class="col-md-1"><strong>&nbsp;</strong></div>
								<div class="col-md-2"><strong>{L_008}</strong></div>
							</div>
<!-- BEGIN busers -->
							<div class="row">
								<div class="col-md-2"><a href="editbannersuser.php?id={busers.ID}">{busers.NAME}</a></div>
								<div class="col-md-3">{busers.COMPANY}</div>
								<div class="col-md-3"><a href="mailto:{busers.EMAIL}">{busers.EMAIL}</a></div>
								<div class="col-md-1">{busers.NUM_BANNERS}</div>
								<div class="col-md-1"><a href="userbanners.php?id={busers.ID}">{L__0024}</a></div>
								<div class="col-md-2"><input type="checkbox" name="delete[]" value="{busers.ID}"></div>
							</div>
<!-- END busers -->
						</div>
					</div>
					<input type="hidden" name="action" value="deleteusers">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<button class="btn btn-primary" type="submit" name="act">{L__0028}</button>
				</form>
			</div>
		</div>