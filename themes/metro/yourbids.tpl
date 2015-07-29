<!-- INCLUDE user_menu_header.tpl -->
<table width="100%" border="0" cellpadding="4" cellspacing="1" align="center">
	<TR>
	<TD colspan="3">
		<TABLE WIDTH=200 HEIGHT=20 BORDER=0 CELLPADDING=0 CELLSPACING=0>
		<TD WIDTH=20 BGCOLOR="#FFFF00">&nbsp;</TD>
		<TD WIDTH=150>{L_30_0098}</TD>
		</TR>
		</TABLE>
	</TD>
	</TR>
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