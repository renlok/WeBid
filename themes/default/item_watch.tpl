<!-- INCLUDE user_menu_header.tpl -->

<div align="center">
	<table width="98%" cellpadding=1 cellspacing=0 border=0>
		<tr>
			<th width="9%" align="center" height="5">
				{L_167}
			</th>
			<th width="39%" height="5" align="center">
				{L_168}
			</th>
			<th width="14%" height="5" align="center">
				{L_169}
			</th>
			<th width="14%" height="5" align="center">
				{L_170}
			</th>
			<th width="14%" align="center" height="5" nowrap>
				{L_171}
			</th>
			<th width="10%" align="center" height="5">
				{L_008}
			</th>
		</tr>
<!-- BEGIN items -->
		<tr align="center" {items.ROWCOLOUR}>
			<td align="center">
				{items.IMAGE}
			</td>
			<td align="left">
				{items.TITLE} {items.BUY_NOW}
			</td>
			<td align="right">
				{items.BIDFORM}			
			</td>
			<td align="center">
				{items.RESERVE}{items.NUMBIDS}
			</td>
			<td align="center">
				{items.TIMELEFT}
			</td>
			<td width="10%" align="center">
				<a href="item_watch.php?delete={items.ID}"><img src="{SITEURL}images/trash.gif" border="0"></a>
			</td>
		</tr>
<!-- BEGINELSE -->
		<tr align="center">
			<td align="center" colspan="6">
				{L_853}
			</td>
		</tr>
<!-- END items -->
	</table>
</div>

<!-- INCLUDE user_menu_footer.tpl -->