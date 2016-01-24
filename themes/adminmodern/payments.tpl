<!-- INCLUDE header.tpl -->
		<div class="row">
			<div class="col-md-3">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
			<div class="col-md-9">
				<h2>{L_5142}&nbsp;&gt;&gt;&nbsp;{L_075}</h2>	
<!-- IF ERROR ne '' -->
				<div class="alert alert-danger" role="alert"><b>{ERROR}</b></div>
<!-- ENDIF -->
				<form name="payments" action="" method="post">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">{L_092}</div>
							</div>
							<div class="row">
								<div class="col-md-9"><strong>{L_087}</strong></div>
								<div class="col-md-3"><strong>{L_008}</strong></div>
							</div>
<!-- BEGIN payments -->
							<div class="row">
								<div class="col-md-9">
									<input type="text" name="new_payments[]" value="{payments.PAYMENT}" size="25">
								</div>
								<div class="col-md-3"><input type="checkbox" name="delete[]" value="{payments.S_ROW_COUNT}"></div>
							</div>
<!-- END payments -->
							<div class="row">
								<div class="col-md-9 text-right">{L_30_0102}</div>
								<div class="col-md-3"><input type="checkbox" class="selectall" value="delete"></div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-9">{L_394}: <input type="text" name="new_payments[]" size="25"></div>
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
<!-- INCLUDE footer.tpl -->