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
	<tr valign="top" {a.BGCOLOUR}>
		<td nowrap="nowrap">
			<b><a href="{SITEURL}item.php?id={a.AUCTIONID}" target="_blank">{a.TITLE}</a></b><br>
			<span class="smallspan">(ID: <a href="{SITEURL}item.php?id={a.AUCTIONID}" target="_blank">{a.AUCTIONID}</a> - {L_25_0121} {a.ENDS})</span>
		</td>
		<td width="33%">
			<a href="{SITEURL}profile.php?user_id={a.WINNERID}&auction_id={a.AUCTIONID}">{a.NICK}</a> {a.FB}
		</td>
		<td width="17%" align="center">
			{a.BIDF}
		</td>
		<td width="10%" align="center">
			{a.QTY}
		</td>
		<td width="10%" nowrap="nowrap">
	<!-- IF a.B_PAID -->
			{L_898}
	<!-- ELSE -->
			<a href="{SITEURL}selling.php?paid={a.ID}{AUCID}">{L_899}</a>
	<!-- ENDIF -->
			<form name="" method="post" action="{SITEURL}order_packingslip.php" id="fees" target="_blank">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<input type="hidden" name="pfval" value="{a.AUCTIONID}">
				<input type="hidden" name="pfwon" value="{a.ID}">
				<input type="hidden" name="user_id" value="{SELLER_ID}">
				<input type="submit" type="button" value="{L_1106}">
			</form>
	<!-- IF a.SHIPPED eq 0 -->
			<img src="{SITEURL}images/clock.png"> <span class="smallspan"><a href="{SITEURL}selling.php?shipped={a.ID}{AUCID}">{L_1116}</a></span>
	<!-- ELSEIF a.SHIPPED eq 1 -->
			<img src="{SITEURL}images/lorry_go.png" border="0"> <span class="smallspan">{L_1117}</span>
	<!-- ELSEIF a.SHIPPED eq 2 -->
			<img src="{SITEURL}images/box.png" border="0"> <span class="smallspan">{L_1109}</span>
	<!-- ENDIF -->
		</td>
	</tr>
<!-- END a -->
<!-- IF NUM_WINNERS eq 0 -->
	<tr>
		<td colspan="5">
			{L_198}
		</td>
	</tr>
<!-- ENDIF -->
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="center">
			{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
			<br>
			{PREV}
<!-- BEGIN pages -->
			{pages.PAGE}&nbsp;&nbsp;
<!-- END pages -->
			{NEXT}
		</td>
	</tr>
</table>

<!-- INCLUDE user_menu_footer.tpl -->
