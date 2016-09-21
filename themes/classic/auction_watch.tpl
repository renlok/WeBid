<!-- INCLUDE user_menu_header.tpl -->

<table width="100%" border="0" cellpadding="4" cellspacing="0" >
	<tr>
		<td colspan="2" height="1">&nbsp;</td>
	</tr>
<!-- BEGIN items -->
	<tr>
		<td>{items.ITEM}</td>
		<td align="right">
			<a href="{SITEURL}auction_watch.php?delete={items.ITEMENCODE}"><img src="{SITEURL}images/trash.gif" border="0" alt="delete"></a>
		</td>
	</tr>
<!-- END items -->
	<tr>
		<td bgcolor="#DDDDDD" colspan=2>
			{L_25_0084}
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<form action="auction_watch.php?insert=true" method="post">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<input type="text" size="60" name="add">
				<input type="submit" value="{L_5204}" class="button">
			</form>
		</td>
	</tr>
</table>
<div align="center">{L_30_0210}</div>

<!-- INCLUDE user_menu_footer.tpl -->
