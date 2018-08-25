<div class="content">
	<div class="tableContent2">
		<div class="titTable2 rounded-top rounded-bottom">
			{TITLE}
		</div>
		<div class="table2">
<!-- IF ERROR ne '' -->
			<div class="error-box">
				{ERROR}
			</div>
<!-- ENDIF -->
<!-- IF B_NOTBOUGHT -->
			<form action="{SITEURL}buy_now.php?id={ID}" method="post">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
<!-- ENDIF -->
				<table border=0 width="100%" cellspacing="0" cellpadding="4">
					<tr>
						<td align=right width="40%"><b>{L_017} :</b></td>
						<td width="60%">{TITLE}</td>
					</tr>
					<tr>
						<td align=right width="50%"><b>{L_125} :</b></td>
						<td>{SELLER} {SELLERNUMFBS} <!-- IF FB_ICON ne '' --><img src="{SITEURL}images/icons/{FB_ICON}" alt="{FB_ICON}" class="fbstar"><!-- ENDIF --></td>
					</tr>
					<tr>
						<td align="right" width="40%"><b>{L_497}:</b></td>
						<td>{BN_PRICE}<!-- IF B_QTY -->{L_868}<!-- ENDIF --></td>
					</tr>
					<tr>
						<td colspan=2 align="center">&nbsp;</td>
					</tr>
<!-- IF B_NOTBOUGHT -->
					<tr>
						<td align="right"><b>{L_284}:</b></td>
						<td>
	<!-- IF B_QTY -->
							<input type="number" name="qty" id="qty" value="1" min="1" max="{LEFT}" step="1" size="15" maxlength="15">{LEFT} {L_5408}
	<!-- ELSE -->
							<input type="hidden" name="qty" value="1">1
	<!-- ENDIF -->
						</td>
					</tr>
					<tr>
						<td align="right">{L_username}</td>
						<td>
							<b>{YOURUSERNAME}</b>
						</td>
					</tr>
	<!-- IF B_USERAUTH -->
					<tr>
						<td align="right">{L_password}</td>
						<td>
							<input type="password" name="password" size="15" maxlength="15">
						</td>
				</tr>
	<!-- ENDIF -->
				</table>
				<div style="text-align:center;">
					<input type="hidden" name="action" value="buy">
					<input type="submit" name="" value="{L_496}" class="button">
				</div>
			</form>
<!-- ELSE -->
			<table width="100%">
				<tr>
					<td align="right" width="50%"><b>{L_893}:</b></td>
					<td>{BN_TOTAL}</td>
				</tr>
	<!-- IF SHIPPINGCOST ne 0 -->
				<tr>
					<td align="right" width="50%"><b>{L_023}:</b></td>
					<td>{SHIPPINGCOST}</td>
				</tr>
	<!-- ENDIF -->
				<tr>
					<td colspan="2" align="center">
						{L_498}
						<form name="" method="post" action="{SITEURL}pay.php?a=2" id="fees">
						<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
						<input type="hidden" name="pfval" value="{WINID}">
						<input type="submit" name="Pay" value="{L_756}" class="pay">
						</form>
					</td>
				</tr>
			</table>
<!-- ENDIF -->
		</div>
	</div>
</div>
