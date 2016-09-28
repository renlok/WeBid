		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_5142}&nbsp;&gt;&gt;&nbsp;{L_075}</h4>
				<form name="payments" action="" method="post">
					<div class="plain-box">{L_092}</div>
					<table width="98%" cellpadding="0" cellspacing="0" class="blank">
						<tr>
							<th>&nbsp;</th>
							<th><b>{L_payment_name}</b></th>
							<th><b>{L_clean_payment_name}</b></th>
							<th><b>{L_008}</b></th>
						</tr>
<!-- BEGIN payments -->
						<tr>
							<td>
								<input type="hidden" name="payment[{payments.ID}][id]" value="{payments.ID}" size="25">
							</td>
							<td>
								<input type="text" name="payment[{payments.ID}][name]" value="{payments.NAME}" size="25">
							</td>
							<td>
								<input type="text" name="payment[{payments.ID}][clean]" value="{payments.CLEAN}" size="25">
							</td>
							<td align="center">
								<input type="checkbox" name="delete[]" value="{payments.ID}">
							</td>
						</tr>
<!-- END payments -->
						<tr>
							<td colspan="3" align="right">{L_30_0102}</td>
							<td align="center"><input type="checkbox" class="selectall" value="delete"></td>
						</tr>
						<tr>
							<td>{L_394}</td>
							<td>
								<input type="text" name="new_payments" size="25">
							</td>
							<td>
								<input type="text" name="new_payments_clean" size="25">
							</td>
							<td>&nbsp;</td>
						</tr>
					</table>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="submit" name="act" class="centre" value="{L_089}">
				</form>
			</div>
		</div>
