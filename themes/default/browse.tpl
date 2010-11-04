<!-- IF B_FEATURED_ITEMS -->
	<table width="98%" border="0" cellspacing="1" cellpadding="4">
		<tr>
			<th width="9%" align="center" height="5">
				{L_167}
			</th>
			<th width="49%" height="5" align="center">
				{L_168}
			</th>
			<th width="14%" height="5" align="center">
				{L_169}
			</th>
			<th width="14%" height="5" align="center">
				{L_170}
			</th>
			<th width="14%" align="center" height="5">
				{L_171}
			</th>
		</tr>
    <!-- BEGIN featured_items -->
		<tr align="center" {featured_items.ROWCOLOUR}<!-- IF featured_items.B_BOLD --> style="font-weight: bold;"<!-- ENDIF -->>
			<td align="center">
				{featured_items.IMAGE}
			</td>
			<td align="left">
                {featured_items.TITLE} {featured_items.BUY_NOW}
				<!-- IF B_SUBTITLE && featured_items.SUBTITLE ne '' --><p class="smallspan">{featured_items.SUBTITLE}</p><!-- ENDIF -->
			</td>
			<td align="right">
				{featured_items.BIDFORM}
			</td>
			<td align="center">
				{featured_items.NUMBIDS}
			</td>
			<td align="center">
				{featured_items.TIMELEFT}
			</td>
		</tr>
    <!-- END featured_items -->
	</table>
    <br class="spacer">
<!-- ENDIF -->

	<table width="98%" border="0" cellspacing="1" cellpadding="4">
		<tr>
			<th width="9%" align="center" height="5">
				{L_167}
			</th>
			<th width="49%" height="5" align="center">
				{L_168}
			</th>
			<th width="14%" height="5" align="center">
				{L_169}
			</th>
			<th width="14%" height="5" align="center">
				{L_170}
			</th>
			<th width="14%" align="center" height="5">
				{L_171}
			</th>
		</tr>
<!-- BEGIN items -->
		<tr align="center" {items.ROWCOLOUR}<!-- IF items.B_BOLD --> style="font-weight: bold;"<!-- ENDIF -->>
			<td align="center">
				{items.IMAGE}
			</td>
			<td align="left">
                {items.TITLE} {items.BUY_NOW}
				<!-- IF B_SUBTITLE && items.SUBTITLE ne '' --><p class="smallspan">{items.SUBTITLE}</p><!-- ENDIF -->
			</td>
			<td align="right">
				{items.BIDFORM}
			</td>
			<td align="center">
				{items.NUMBIDS}
			</td>
			<td align="center">
				{items.TIMELEFT}
			</td>
		</tr>
<!-- END items -->
		<tr align="center">
			<td colspan="5">{NUM_AUCTIONS}</td>
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