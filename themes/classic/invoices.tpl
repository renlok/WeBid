<!-- INCLUDE user_menu_header.tpl -->

<table width="100%" cellspacing="3" cellpadding="4">
<tr>
	<th style="width: 10%; text-align: center;" class="titTable7">{L_1041}</th>
	<th class="titTable7">{L_1039}</th>
	<th style="width: 10%; text-align: center;" class="titTable7">{L_1053}</th>
	<th style="width: 10%; text-align: center;" class="titTable7">{L_560}</th>
</tr>
<!-- BEGIN topay -->
<tr>
	<td style="text-align: center;">
		<span class="titleText125">{L_1041}: {topay.INVOICE}</span>
		<p class="smallspan">{topay.DATE}</p>
	</td>
	<td>{topay.INFO}</td>
	<td style="text-align: center;">{topay.TOTAL}</td>
	<td style="text-align: center;">
		<!-- IF topay.PAID -->{L_898}<br><!-- ENDIF --><a href="{SITEURL}order_print.php?id={topay.INVOICE}" target="_blank">{L_1058}</a>
	</td>
</tr>
<!-- END topay -->
</table>

<br /><br />
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td align="center">
		{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
		<br />
		{PREV}
<!-- BEGIN pages -->
		{pages.PAGE}&nbsp;&nbsp;
<!-- END pages -->
		{NEXT}
	</td>
</tr>
</table>

<!-- INCLUDE user_menu_footer.tpl -->
