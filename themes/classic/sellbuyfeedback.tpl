<!-- INCLUDE user_menu_header.tpl -->

<table width="100%" border="0" cellspacing="1" cellpadding="4">
<!-- IF NUM_AUCTIONS gt 0 -->
	<tr>
		<th>
			{L_458}
		</th>
		<th>
			{L_25_0004}
		</th>
		<th>
			{L_303}
		</th>
		<th>
			{L_25_0006}
		</th>
		<th>
			{L_284}
		</th>
	</tr>
	<!-- BEGIN fbs -->
	<tr {fbs.ROWCOLOUR}>
		<td>
			<b><a href="item.php?id={fbs.ID}" target="_blank">{fbs.TITLE}</a></b><br />
			<b>{L_869}:</b> {fbs.CLOSINGDATE}
		</td>
		<td>
			{fbs.WINORSELLNICK} , {fbs.WINORSELL} ( <a href="{SITEURL}feedback.php?auction_id={fbs.ID}&wid={fbs.WINNER}&sid={fbs.SELLER}&ws={fbs.WS}">{L_207}</a> )
		</td>
		<td>
			<a href="mailto:{fbs.WINORSELLEMAIL}">{fbs.WINORSELLEMAIL}</a>
		</td>
		<td>
			{fbs.BIDFORM}
		</td>
		<td>
			{fbs.QTY}
		</td>
	</tr>
	<!-- END fbs -->
	<tr>
		<td>
			<b>{L_30_0213}</b>
		</td>
	</tr>
<!-- ENDIF -->
</table>

<!-- INCLUDE user_menu_footer.tpl -->
