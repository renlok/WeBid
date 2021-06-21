<!-- INCLUDE user_menu_header.tpl -->

<div class="padding">
	<table width="98%" cellpadding="1" cellspacing="0" border="0">
<!-- BEGIN items -->
		<tr align="center" {items.ROWCOLOUR}>
			<td align="center" width="15%">
				<a href="{SITEURL}item.php?id={items.ID}"><img src="{items.IMAGE}" border="0"></a>
			</td>
			<td align="left"<!-- IF items.B_BOLD --> style="font-weight: bold;"<!-- ENDIF -->>
				<a href="{SITEURL}item.php?id={items.ID}" class="bigfont">{items.TITLE}</a>
				<!-- IF B_SUBTITLE && items.SUBTITLE ne '' --><p class="smallspan">{items.SUBTITLE}</p><!-- ENDIF -->
				<p>{L_949} {items.CLOSES}</p>
			</td>
			<td align="center" width="15%">
	<!-- IF items.BUY_NOW neq '' -->
				<span class="redfont bigfont">{items.BUY_NOW}</span>
	<!-- ELSE -->
				<span class="grayfont">{L_951}</span>
	<!-- ENDIF -->
			</td>
			<td align="center" width="15%">
				<span class="bigfont">{items.BIDFORM}</span>
				<p class="smallspan">{items.NUMBIDS}</p>
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
