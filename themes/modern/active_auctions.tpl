<div class="well">
	<h4>{L_219}<a href="{SITEURL}profile.php?user_id={USER_ID}">{USERNAME}</a> <a href="{SITEURL}rss.php?feed=9&user_id={USER_ID}"><img src="{SITEURL}images/rss.png" alt="RSS" border="0"></a></h4>
</div>
<table class="table table-bordered table-condensed table-striped">
	<tr align="center">
		<th width="10%">{L_167}</th>
		<th width="45%">{L_168}</th>
		<th width="15%">{L_169}</th>
		<th width="15%">{L_170}</th>
		<th width="15%">{L_171}</th>
	</tr>
<!-- BEGIN auctions -->
	<tr {auctions.BGCOLOUR}>
		<td width="10%"><a href="{SITEURL}item.php?id={auctions.ID}"><img class="img-rounded" src="{auctions.PIC_URL}" width="100%" border="0" alt="image"></a></td>
		<td width="45%">
			<a href="{SITEURL}item.php?id={auctions.ID}">{auctions.TITLE}</a>
	<!-- IF auctions.B_BUY_NOW and not auctions.B_BNONLY -->
			&nbsp;&nbsp;(<a href="{SITEURL}buy_now.php?id={auctions.ID}"><img src="{auctions.BNIMG}" border="0" class="buynow"></a> {auctions.BNFORMAT})
	<!-- ENDIF -->
		</td>
		<td width="15%">
	<!-- IF auctions.B_BNONLY -->
			<a href="{SITEURL}buy_now.php?id={auctions.ID}"><img src="{auctions.BNIMG}" border="0" class="buynow"></a> {auctions.BNFORMAT}
	<!-- ELSE -->
			{auctions.BIDFORMAT}
	<!-- ENDIF -->
		</td>
		<td width="15%">{auctions.NUM_BIDS} </td>
		<td width="15%"><small>{auctions.TIMELEFT}</small></td>
	</tr>
<!-- BEGINELSE -->
	<tr align="center">
		<td colspan="5">{L_910}</td>
	</tr>
<!-- END auctions -->
</table>
<!-- IF B_MULPAG -->
<div class="text-center">
	{L_5117} {PAGE} {L_5118} {PAGES}
	<br>
	<!-- IF B_NOTLAST -->
	<a href="active_auctions.php?PAGE={PREV}&user_id={USER_ID}"><u>{L_5119}</u></a>&nbsp;&nbsp;
	<!-- ENDIF -->
	{PAGENA}
	&nbsp;&nbsp;
	<!-- IF B_NOTLAST -->
	<a href="active_auctions.php?PAGE={NEXT}&user_id={USER_ID}"><u>{L_5120}</u></a>
	<!-- ENDIF -->
</div>
<!-- ENDIF -->