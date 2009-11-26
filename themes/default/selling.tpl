<!-- INCLUDE user_menu_header.tpl -->

<table width="100%" border="0" cellspacing="1" cellpadding="4">
	<tr>
		<th>
			{L_458}
		</th>
		<th>
			{L_455}
		</th>
		<th>
			{L_457}
		</th>
		<th>
			{L_284}
		</th>
		<th>&nbsp;</th>
	</tr>
<!-- BEGIN a -->
	<!-- BEGIN w -->
	<tr valign="top" {a.w.BGCOLOUR}>
		<td nowrap="nowrap">
			<b><a href="{SITEURL}item.php?id={a.AUCTIONID}" target="_blank">{a.TITLE}</a></b><br>
			<span class="smallspan">(ID: <a href="{SITEURL}item.php?id={a.AUCTIONID}" target="_blank">{a.AUCTIONID}</a> - {L_25_0121} {a.ENDS})</span>
		</td>
		<td width="33%">
			<a href="{SITEURL}profile.php?user_id={a.w.WINNERID}">{a.w.NICK}</a> {a.w.FB}
		</td>
		<td width="17%" align="right">
			{a.w.BIDF}
		</td>
		<td width="10%">
			{a.w.QTY}
		</td>
		<td width="10%" nowrap="nowrap">
<!-- IF a.w.B_PAID -->
			{L_898}
<!-- ELSE -->
			<a href="{SITEURL}selling.php?paid={a.w.ID}{AUCID}">{L_899}</a>
<!-- ENDIF -->
		</td>
	</tr>
	<!-- END w -->
<!-- END a -->
<!-- IF NUM_WINNERS eq 0 -->
	<tr>
		<td colspan="5">
			{L_198}
		</td>
	</tr>
<!-- ENDIF -->
</table>

<!-- INCLUDE user_menu_footer.tpl -->