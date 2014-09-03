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
		</td>
		<td>
	<!-- IF items.B_PAID -->
    		{L_755}
    <!-- ELSE -->
    		<form name="" method="post" action="{SITEURL}pay.php?a=2" id="fees">
            <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
            <input type="hidden" name="pfval" value="{items.AUC_ID}">
            <input type="submit" name="Pay" value="{L_756}" class="pay">
            </form>
    <!-- ENDIF -->
		</td>
	</tr>
<!-- END items -->
</table>

<!-- INCLUDE user_menu_footer.tpl -->