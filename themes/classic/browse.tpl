<br>
<!-- IF B_FEATURED_ITEMS -->
	<table width="99%" border="0" cellspacing="1" cellpadding="4">
		<tr>
			<td class="titTable4" colspan="4">{L_NAY_01}</td>
		</tr>
	<!-- BEGIN featured_items -->
		<tr align="center"<!-- IF featured_items.B_HIGHLIGHTED --> bgcolor="#fea100"<!-- ELSEIF (featured_items.S_ROW_COUNT % 2) == 1 --> bgcolor="#FFFEEE"<!-- ENDIF -->>
			<td align="center" width="15%">
				<a href="{SITEURL}item.php?id={featured_items.ID}"><img src="{featured_items.IMAGE}" border="0"></a>
			</td>
			<td align="left"<!-- IF featured_items.B_BOLD --> style="font-weight: bold;"<!-- ENDIF -->>
				<a href="{SITEURL}item.php?id={featured_items.ID}" class="bigfont">{featured_items.TITLE}</a>
				<!-- IF B_SUBTITLE && featured_items.SUBTITLE ne '' --><p class="smallspan">{featured_items.SUBTITLE}</p><!-- ENDIF -->
				<p>{L_949} {featured_items.CLOSES}</p>
			</td>
			<td align="center" width="15%">
	<!-- IF featured_items.BUY_NOW neq '' -->
				<span class="redfont bigfont">{featured_items.BUY_NOW}</span>
	<!-- ELSE -->
				<span class="grayfont">{L_951}</span>
	<!-- ENDIF -->
			</td>
			<td align="center" width="15%">
				<span class="bigfont">{featured_items.BIDFORM}</span>
				<p class="smallspan">{featured_items.NUMBIDS}</p>
			</td>
		</tr>
	<!-- END featured_items -->
	</table>
	<br class="spacer">
<!-- ENDIF -->

	<table width="99%" border="0" cellspacing="1" cellpadding="4">
		<tr>
			<td class="titTable4" colspan="4">{L_NAY_02}</td>
		</tr>
<!-- BEGIN items -->
		<tr align="center"<!-- IF items.B_HIGHLIGHTED --> bgcolor="#fea100"<!-- ELSEIF (items.S_ROW_COUNT % 2) == 1 --> bgcolor="#FFFEEE"<!-- ENDIF -->>
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
		</tr>
<!-- END items -->
		<tr align="center">
			<td colspan="4">{NUM_AUCTIONS}</td>
		</tr>
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
