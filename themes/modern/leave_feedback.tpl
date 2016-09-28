<!-- INCLUDE user_menu_header.tpl -->

<div class="panel panel-default">
	<table class="table table-bordered table-condensed table-striped">
		<tr>
			<th>
				{L_458}
			</th>
			<th>
				{L_25_0004}
			</th>
			<th class="hidden-xs">
				{L_303}
			</th>
			<th>
				{L_25_0006}
			</th>
			<th class="hidden-xs">
				{L_284}
			</th>
		</tr>
<!-- BEGIN fbs -->
		<tr <!-- IF (fbs.S_ROW_COUNT % 2) == 1 --> bgcolor="#FFFEEE"<!-- ENDIF -->>
			<td>
				<b><a href="item.php?id={fbs.ID}" target="_blank">{fbs.TITLE}</a></b><br />
				<small><span class="text-muted"><b>{L_869}:</b> {fbs.CLOSINGDATE}</span></small>
			</td>
			<td>
				{fbs.WINORSELLNICK} , {fbs.WINORSELL} <br> <a class="label label-primary" href="{SITEURL}feedback.php?auction_id={fbs.ID}&wid={fbs.WINNER}&sid={fbs.SELLER}&ws={fbs.WS}">{L_207}</a>
			</td>
			<td class="hidden-xs">
				<a href="mailto:{fbs.WINORSELLEMAIL}">{fbs.WINORSELLEMAIL}</a>
			</td>
			<td>
				{fbs.BIDFORM}
			</td>
			<td class="hidden-xs">
				{fbs.QTY}
			</td>
		</tr>
<!-- BEGINELSE -->
		<tr>
			<td>
				<b>{L_30_0213}</b>
			</td>
		</tr>
<!-- END fbs -->
	</table>
</div>

<!-- INCLUDE user_menu_footer.tpl -->
