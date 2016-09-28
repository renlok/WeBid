<small><span class="text-muted">{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}</span></small>
<!-- IF B_FEATURED_ITEMS -->
<div class="row">
	<div class="col-md-12">
		<div class="browse-header"><h2>{L_NAY_01}</h2></div>
		<table class="table table-condensed table-hover">
			<tr>
				<th width="15%" class="tr-image"> <small>{L_741}</small></th>
				<th class="tr-title"> <small>{L_017}</small></th>
				<th width="10%" class="tr-bids"> <small>{L_169}</small></th>
				<th width="8%" class="hidden-xs tr-bindsno"> <small>{L_170}</small></th>
				<th width="18%" class="tr-timeleft hidden-xs"> <small>{L_171}</small></th>
			</tr>
	<!-- BEGIN featured_items -->
			<tr align="center"<!-- IF featured_items.B_HIGHLIGHTED --> bgcolor="#fea100"<!-- ELSEIF (featured_items.S_ROW_COUNT % 2) == 1 --> bgcolor="#FFFEEE"<!-- ENDIF -->>
				<td align="center">
					<a href="{SITEURL}item.php?id={featured_items.ID}"><img class="search-res img-rounded" src="{featured_items.IMAGE}" border="0"></a>
				</td>
				<td align="left"<!-- IF featured_items.B_BOLD --> style="font-weight: bold;"<!-- ENDIF -->>
					<a href="{SITEURL}item.php?id={featured_items.ID}" class="bigfont">{featured_items.TITLE}</a>
				<!-- IF B_SUBTITLE && featured_items.SUBTITLE ne '' --><p><small>{featured_items.SUBTITLE}</small></p><!-- ENDIF -->
				</td>
				<td align="center">
	<!-- IF featured_items.BUY_NOW neq '' -->
					<div class="buy-now-feat text-center">{featured_items.BUY_NOW}</div><br>
	<!-- ELSE -->
					<div class="no-buy-now-feat">{L_951}</div><br>
	<!-- ENDIF -->
					{featured_items.BIDFORM}<span class="label label-success visible-xs">{featured_items.NUMBIDS}</span>
				</td>
				<td class="hidden-xs" align="center">
					<span class="label label-success">{featured_items.NUMBIDS}</span>
				</td>
				<td class="hidden-xs">
					{L_949} {featured_items.CLOSES}
				</td>
			</tr>
	<!-- END featured_items -->
		</table>
	</div>
</div>
<br class="spacer">
<!-- ENDIF -->
<div class="row">
	<div class="col-md-12">
		<div class="browse-header"><h2>{L_NAY_02}</h2></div>
		<table class="table table-condensed table-hover">
			<tr>
				<th width="12%" class="tr-image"> <small>{L_741}</small></th>
				<th class="tr-title"> <small>{L_017}</small></th>
				<th width="10%" class="tr-bids"> <small>{L_169}</small></th>
				<th width="8%" class="hidden-xs tr-bindsno"> <small>{L_170}</small></th>
				<th width="18%" class="tr-timeleft hidden-xs"> <small>{L_171}</small></th>
			</tr>
<!-- BEGIN items -->
			<tr align="center"<!-- IF items.B_HIGHLIGHTED --> bgcolor="#fea100"<!-- ELSEIF (items.S_ROW_COUNT % 2) == 1 --> bgcolor="#FFFEEE"<!-- ENDIF -->>
				<td align="center">
					<a href="{SITEURL}item.php?id={items.ID}"><img class="search-res img-rounded" src="{items.IMAGE}" border="0"></a>
				</td>
				<td align="left"<!-- IF items.B_BOLD --> style="font-weight: bold;"<!-- ENDIF -->>
					<a href="{SITEURL}item.php?id={items.ID}" class="bigfont">{items.TITLE}</a>
					<!-- IF B_SUBTITLE && items.SUBTITLE ne '' --><p><small>{items.SUBTITLE}</small></p><!-- ENDIF -->
				</td>
				<td align="center">
	<!-- IF items.BUY_NOW neq '' -->
					<div class="buy-now-feat text-center">{items.BUY_NOW}</div><br>
	<!-- ELSE -->
					<div class="no-buy-now-feat">{L_951}</div><br>
	<!-- ENDIF -->
						{items.BIDFORM}<span class="label label-success visible-xs">{items.NUMBIDS}</span>
				</td>
				<td align="center" class="hidden-xs">
					<span class="label label-success">{items.NUMBIDS}</span>
				</td>
				<td class="hidden-xs">
					{L_949} {items.CLOSES}
				</td>
			</tr>
<!-- END items -->
		</table>
		<div class="text-center">
			{L_290} {NUM_AUCTIONS}
		</div>
	</div>
</div>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="center">
			<small><span class="text-muted">{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}</span></small>
			<nav>
				<ul class="pagination">
					<br>
					<li>{PREV}</li>
<!-- BEGIN pages -->
					<li>{pages.PAGE}</li>
<!-- END pages -->
					<li>{NEXT}</li>
				</ul>
			</nav>
		</td>
	</tr>
</table>
