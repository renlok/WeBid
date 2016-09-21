		<div class="row">
			<div class="col-md-3">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
			<div class="col-md-9">
				<h2>{L_5142}&nbsp;&gt;&gt;&nbsp;{L_25_0169}</h2>
				<form name="memberlevels" action="" method="post">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">{L_25_0170}</div>
							</div>
							<div class="row">
								<div class="col-md-3"><strong>{L_25_0171}</strong></div>
								<div class="col-md-6"><strong>{L_25_0167}</strong></div>
								<div class="col-md-3"><strong>{L_008}</strong></div>
							</div>
<!-- BEGIN mtype -->
							<div class="row">
								<div class="col-md-3">
									<input type="hidden" name="old_membertypes[{mtype.ID}][feedbacks]" value="{mtype.FEEDBACK}">
									<input type="text" name="new_membertypes[{mtype.ID}][feedbacks]" value="{mtype.FEEDBACK}" size="5"></div>
								<div class="col-md-5">
									<input type="hidden" name="old_membertypes[{mtype.ID}][icon]" value="{mtype.ICON}">
									<input type="text" name="new_membertypes[{mtype.ID}][icon]" value="{mtype.ICON}" size="25">
								</div>
								<div class="col-md-1"><img src="../images/icons/{mtype.ICON}" align="middle"></div>
								<div class="col-md-3"><input type="checkbox" name="delete[]" value="{mtype.ID}"></div>
							</div>
<!-- END mtype -->
							<div class="row">
								<div class="col-md-9 text-right">{L_30_0102}</div>
								<div class="col-md-3"><input type="checkbox" class="selectall" value="delete"></div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-3">{L_394}: <input type="text" name="new_membertype[feedbacks]" size="5"></div>
								<div class="col-md-6"><input type="text" name="new_membertype[icon]" size="30"></div>
								<div class="col-md-3">&nbsp;</div>
							</div>
						</div>
					</div>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<button class="btn btn-primary" type="submit" name="act" class="centre">{L_089}</button>
				</form>
			</div>
		</div>