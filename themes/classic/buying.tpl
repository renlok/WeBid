<!-- INCLUDE user_menu_header.tpl -->

<table width="100%" border="0" cellspacing="1" cellpadding="4">
<!-- BEGIN items -->
	<tr valign="top">
		<td colspan="4">
			{L_458}
			<b><a href="item.php?id={items.AUC_ID}" target="_blank">{items.TITLE}</a></b>
			(ID: <a href="item.php?id={items.AUC_ID}" target="_blank">{items.AUC_ID}</a> - {L_25_0121} {items.ENDS})
		</td>
	</tr>
	<tr>
		<th width="30%">
			{L_125}
		</th>
		<th width="20%">
			{L_460}
		</th>
		<th width="15%">
			{L_461}
		</th>
		<th width="10%">
			{L_284}
		</th>
		<th width="15%">
			{L_189}
		</th>
		<th width="10%">
			{L_755}
		</th>
	</tr>
	<tr valign="top">
		<td>
			{items.SELLNICK}&nbsp;&nbsp;{items.FB_LINK}
		</td>
		<td>
			<a href="mailto:{items.SELLEMAIL}">{items.SELLEMAIL}</a>
		</td>
		<td align="right">
			{items.FBID}
		</td>
		<td align="center">
			{items.QTY}
		</td>
		<td align="right">
			{items.TOTAL}
	<!-- IF items.SHIPPED eq 0 -->
			<img src="{SITEURL}images/clock.png"> <span class="smallspan">{L_1107}</span>
	<!-- ELSEIF items.SHIPPED eq 1 -->
			<img src="{SITEURL}images/lorry_go.png" border="0"> <span class="smallspan"><a href="{SITEURL}buying.php?shipped={items.ID}">{L_1108}</a></span>
	<!-- ELSEIF items.SHIPPED eq 2 -->
			<img src="{SITEURL}images/box.png" border="0"> <span class="smallspan">{L_1109}</span>
	<!-- ENDIF -->
		</td>
		<td>
	<!-- IF items.B_PAID -->
			{L_755}
	<!-- ELSE -->
			<form name="" method="post" action="{SITEURL}pay.php?a=2" id="fees">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<input type="hidden" name="pfval" value="{items.ID}">
				<input type="submit" name="Pay" value="{L_756}" class="pay">
			</form>
	<!-- ENDIF -->
		</td>
	</tr>
<!-- END items -->
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
