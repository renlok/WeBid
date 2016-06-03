		<div class="row">
			<div class="col-md-3">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
			<div class="col-md-9">
				<h2>{L_25_0012}&nbsp;&gt;&gt;&nbsp;{L_445}</h2>
				<form name="errorlog" action="" method="post">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">{L_1142}</div>
							</div>
<!-- BEGIN gateways -->
							<h4>{gateways.NAME}</h4>
							<div class="row">
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-12">
											<input type="hidden" name="{gateways.PLAIN_NAME}[id]" value="{gateways.GATEWAY_ID}">
											<a href="{gateways.WEBSITE}" target="_blank">{gateways.ADDRESS_NAME}</a>:<br><input type="text" name="{gateways.PLAIN_NAME}[address]" value="{gateways.ADDRESS}" size="50">
										</div>
									</div>
	<!-- IF gateways.B_PASSWORD -->
									<div class="row">
										<div class="col-md-12">
											<p>{gateways.PASSWORD_NAME}:<br><input type="text" name="{gateways.PLAIN_NAME}[password]" value="{gateways.PASSWORD}" size="50"></p>
										</div>
									</div>
	<!-- ELSE -->
									<input type="hidden" name="{gateways.PLAIN_NAME}[password]" value="">
	<!-- ENDIF -->
								</div>
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-12">
											<input type="checkbox" name="{gateways.PLAIN_NAME}[required]"{gateways.REQUIRED}> {L_446}
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<input type="checkbox" name="{gateways.PLAIN_NAME}[active]"{gateways.ENABLED}> {L_447}
										</div>
									</div>
								</div>
							</div>
<!-- END gateways -->
						</div>
					</div>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<button class="btn btn-primary" type="submit" name="act">{L_530}</button>
				</form>
			</div>
		</div>
