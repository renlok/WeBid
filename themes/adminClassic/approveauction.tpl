		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_239}&nbsp;&gt;&gt;&nbsp;{PAGE_TITLE}</h4>
				<table width="98%" celpadding="0" cellspacing="0" class="blank">
					<tr>
						<td width="20%">{L_312}</td>
						<td>{TITLE}</td>
					</tr>
					<tr>
						<td>{L_313}</td>
						<td>{NICK}</td>
					</tr>
					<tr>
						<td>{L_314}</td>
						<td>{STARTS}</td>
					</tr>
					<tr>
						<td>{L_022}</td>
						<td>{DURATION}</td>
					</tr>
					<tr>
						<td>{L_287}</td>
						<td>{CATEGORY}</td>
					</tr>
					<tr>
						<td>{L_018}</td>
						<td>{DESCRIPTION}</td>
					</tr>
					<tr>
						<td>{L_116}</td>
						<td>{CURRENT_BID}</td>
					</tr>
					<tr>
						<td>{L_258}</td>
						<td>{QTY}</td>
					</tr>
					<tr>
						<td>{L_021}</td>
						<td>{RESERVE_PRICE}</td>
					</tr>
					<tr>
						<td>{L_300}</td>
						<td>
<!-- IF SUSPENDED eq 0 -->
							{L_no}
<!-- ELSE -->
							{L_yes}
<!-- ENDIF -->
						</td>
					</tr>
					<tr>
						<td colspan="2">
							{L_approve_auction_confirmation}
						</td>
					</tr>
					<tr>
						<td width="204">&nbsp;</td>
						<td>
							<form name="details" action="" method="post">
								<input type="hidden" name="id" value="{ID}">
								<input type="hidden" name="offset" value="{OFFSET}">
								<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
								<button type="submit" name="action" value="Yes">{L_yes}</button>
								<button type="submit" name="action" value="No">{L_no}</button>
							</form>
						</td>
					</tr>
				</table>
			</div>
		</div>