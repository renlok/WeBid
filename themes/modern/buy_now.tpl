<div class="row">
	<div class="col-md-12">
		<div class="col-md-6 col-md-offset-3 well">
			<legend>{TITLE}</legend>
<!-- IF ERROR ne '' -->
			<div class="alert alert-danger">
				{ERROR}
			</div>
<!-- ENDIF -->
<!-- IF B_NOTBOUGHT -->
			<form action="{SITEURL}buy_now.php?id={ID}" method="post">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
<!-- ENDIF -->
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<table class="table table-striped">
							<tr>
								<td width="30%"><b>{L_017} :</b></td>
								<td width="70%">{TITLE}</td>
							</tr>
							<tr>
								<td width="30%"><b>{L_125} :</b></td>
								<td>{SELLER} {SELLERNUMFBS} <!-- IF FB_ICON ne '' --><img src="{SITEURL}images/icons/{FB_ICON}" alt="{FB_ICON}" class="fbstar"><!-- ENDIF --></td>
							</tr>
							<tr>
								<td width="30%"><b>{L_497}:</b></td>
								<td>{BN_PRICE}<!-- IF B_QTY -->{L_868}<!-- ENDIF --></td>
							</tr>
							<tr>
								<td colspan=2 align="center">&nbsp;</td>
							</tr>
<!-- IF B_NOTBOUGHT -->
							<tr>
								<td><b>{L_284}:</b></td>
								<td>
	<!-- IF B_QTY -->
									<input type="number" name="qty" id="qty" value="1" min="1" max="{LEFT}" step="1" class="form-control">{LEFT} {L_5408}
	<!-- ELSE -->
									<input type="hidden" name="qty" class="form-control" value="1">1
	<!-- ENDIF -->
								</td>
							</tr>
							<tr>
								<td>{L_username}</td>
								<td>
									<b>{YOURUSERNAME}</b>
								</td>
							</tr>
	<!-- IF B_USERAUTH -->
							<tr>
								<td>{L_password}</td>
								<td>
									<input type="password" name="password" class="form-control">
								</td>
							</tr>
	<!-- ENDIF -->
						</table>
					</div>
				</div>
				<div class="text-center">
					<input type="hidden" name="action" value="buy">
					<input type="submit" name="" value="{L_496}" class="btn btn-primary">
				</div>
			</form>
<!-- ELSE -->
							<tr>
								<td align="right" width="40%"><b>{L_893}:</b></td>
								<td>{BN_TOTAL}</td>
							</tr>
	<!-- IF SHIPPINGCOST ne 0 -->
							<tr>
								<td align="right" width="40%"><b>{L_023}:</b></td>
								<td>{SHIPPINGCOST}</td>
							</tr>
	<!-- ENDIF -->
							<tr>
								<td colspan="2" align="center">
									<div class="alert alert-success">{L_498}</div>
									<form name="" method="post" action="{SITEURL}pay.php?a=2" id="fees">
									<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
									<input type="hidden" name="pfval" value="{WINID}">
									<input type="submit" name="Pay" value="{L_756}" class="pay btn btn-primary">
									</form>
								</td>
							</tr>
						</table>
					</div>
				</div>
<!-- ENDIF -->
		</div>
	</div>
</div>
