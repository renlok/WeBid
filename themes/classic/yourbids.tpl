<!-- INCLUDE user_menu_header.tpl -->
<table width="100%" border="0" cellpadding="4" cellspacing="1" align="center">
	<tr>
		<td colspan="3">
			<table width="200" height="20" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="20" bgcolor="#FFFF00">&nbsp;</td>
					<td width="150">{L_30_0098}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th align="center">
			{L_168}
		</th>
		<th width="15%" align="center">
			{L_461}
		</th>
		<th width="15%" align="center">
			{L_116}
		</th>
		<th width="15%" align="center">
			{L_171}
		</th>
	</tr>
<!-- BEGIN bids -->
	<tr {bids.BGCOLOUR}>
		<td align="left">
			<a href="item.php?id={bids.ID}">{bids.TITLE}</a>
		</td>
		<td>
			{bids.BID} <!-- IF bids.QTY gt 1 -->(x {bids.QTY} {L_5492})<!-- ENDIF -->
			<!-- IF bids.PROXYBID ne '' --><p><span class="smallspan">{bids.PROXYBID}</span></p><!-- ENDIF -->
		</td>
		<td>
			{bids.CBID}
		</td>
		<td align="center">
			{bids.TIMELEFT}
		</td>
	</tr>
<!-- END bids -->
<!-- IF NUM_BIDS eq 0 -->
	<tr align="center">
		<td colspan="5">&nbsp;</td>
	</tr>
<!-- ENDIF -->
</table>

<!-- INCLUDE user_menu_footer.tpl -->