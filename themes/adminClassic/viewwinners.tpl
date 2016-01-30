		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_239}&nbsp;&gt;&gt;&nbsp;{L_30_0176}</h4>
				<p><b>{L_113}: </b> {ID}</p>
				<p><b>{L_197}: </b> {TITLE}</p>
				<p><b>{L_125}: </b> {S_NICK} ({S_NAME})</p>
				<p><b>{L_127}: </b> {MIN_BID}</p>
				<p><b>{L_111}: </b> {STARTS}</p>
				<p><b>{L_30_0177}: </b> {ENDS}</p>
				<p><b>{L_257}: </b> {AUCTION_TYPE}</p>
				<h4 class="rounded-top rounded-bottom" style="width: 98%;">{L_453}</h4>
<!-- IF B_WINNERS -->
				<table width="98%" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<th><b>{L_176}</b></td>
						<th><b>{L_30_0179}</b></td>
						<th><b>{L_284}</b></td>
					</tr>
	<!-- BEGIN winners -->
					<tr>
						<td>{winners.W_NICK} ({winners.W_NAME})</td>
						<td>{winners.BID}</td>
						<td align="center">{winners.QTY}</td>
					</tr>
	<!-- END winners -->
				</table>
<!-- ELSE -->
				{L_30_0178}
<!-- ENDIF -->
				<h4 class="rounded-top rounded-bottom" style="width: 98%;">{L_30_0180}</h4>
<!-- IF B_BIDS -->
				<table width="98%" cellpadding="0" cellspacing="0">
					<tr>
						<th><b>{L_176}</b></td>
						<th><b>{L_30_0179}</b></td>
						<th><b>{L_284}</b></td>
					</tr>
	<!-- BEGIN bids -->
					<tr>
						<td>{bids.W_NICK} ({bids.W_NAME})</td>
						<td>{bids.BID}</td>
						<td align="center">{bids.QTY}</td>
					</tr>
	<!-- END bids -->
				</table>
<!-- ELSE -->
				{L_30_0178}
<!-- ENDIF -->
			</div>
		</div>