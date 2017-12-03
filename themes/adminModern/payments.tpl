		<div class="row">
			<div class="col-md-3">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
			<div class="col-md-9">
				<h4>{L_5142}&nbsp;&gt;&gt;&nbsp;{L_075}</h4>
				<form name="payments" action="" method="post">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">{L_092}</div>
							</div>
							<div class="row">
								<div class="col-md-5"><strong>{L_payment_name}</strong></div>
								<div class="col-md-5"><strong>{L_clean_payment_name}</strong></div>
								<div class="col-md-2"><strong>{L_008}</strong></div>
							</div>
<!-- BEGIN payments -->
							<div class="row">
								<div class="col-md-5">
									<input type="hidden" name="payment[{payments.ID}][id]" value="{payments.ID}" size="25">
									<input type="text" name="payment[{payments.ID}][name]" value="{payments.NAME}" size="25">
								</div>
								<div class="col-md-5">
									<input type="text" name="payment[{payments.ID}][clean]" value="{payments.CLEAN}" size="25">
								</div>
								<div class="col-md-2"><input type="checkbox" name="delete[]" value="{payments.ID}"></div>
							</div>
<!-- END payments -->
							<div class="row">
								<div class="col-md-10 text-right">{L_30_0102}</div>
								<div class="col-md-2"><input type="checkbox" class="selectall" value="delete"></div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-5">{L_394}: <input type="text" name="new_payments" size="25"></div>
								<div class="col-md-5"><input type="text" name="new_payments_clean" size="25"></div>
								<div class="col-md-2">&nbsp;</div>
							</div>
						</div>
					</div>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<button class="btn btn-primary" type="submit" name="act" class="centre">{L_089}</button>
				</form>
			</div>
		</div>
