				<ul class="list-group">
					<li class="list-group-item active">{L_25_0012}</li>
					<li class="list-group-item"><a href="{SITEURL}admin/fees.php">{L_25_0012}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/fee_gateways.php">{L_445}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/enablefees.php">{L_enable_fees}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/accounts.php">{L_854}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/invoice_settings.php">{L_invoice_settings}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/invoice.php">{L_766}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/tax.php">{L_tax_settings}</a></li>
					<li class="list-group-item"><a href="{SITEURL}admin/tax_levels.php">{L_1083}</a></li>
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
