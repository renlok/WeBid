<div class="content">
	<div class="tableContent2">
		<div class="titTable2 rounded-top rounded-bottom">
			{L_220}<a href="{SITEURL}profile.php?user_id={USER_ID}">{USERNAME}</a>
		</div>
		<div class="table2">
			<table width="100%" border=0 cellpadding=4 cellspacing=1>
				<tr align="center">
					<th width="10%">{L_167}</th>
					<th width="45%">{L_168}</th>
					<th width="15%">{L_169}</th>
					<th width="15%">{L_170}</th>
					<th width="15%">{L_171a}</th>
				</tr>
<!-- BEGIN auctions -->
				<tr style="text-align:center;" {auctions.BGCOLOUR}>
					<td width="10%"><a href="{SITEURL}item.php?id={auctions.ID}"><img src="{auctions.PIC_URL}" width="{THUMBWIDTH}" border='0' alt="image"></a></td>
					<td width="45%">
						<a href="{SITEURL}item.php?id={auctions.ID}">{auctions.TITLE}</a>
	<!-- IF auctions.B_BUY_NOW and not auctions.B_BNONLY -->
						&nbsp;&nbsp;(<a href="{SITEURL}buy_now.php?id={auctions.ID}"><img align="middle" src="{auctions.BNIMG}" border="0"></a> {auctions.BNFORMAT})
	<!-- ENDIF -->
					</td>
					<td width="15%">
	<!-- IF auctions.B_BNONLY -->
						<a href="{SITEURL}buy_now.php?id={auctions.ID}"><img src="{auctions.BNIMG}" border="0" class="buynow"></a> {auctions.BNFORMAT}
	<!-- ELSE -->
								{auctions.BIDFORMAT}
	<!-- ENDIF --></td>
					<td width="15%">{auctions.NUM_BIDS}</td>
					<td width="15%">{auctions.TIMELEFT}</td>
				</tr>
<!-- END auctions -->
<!-- BEGIN no_auctions -->
				<tr align="center">
					<td colspan="5">{L_910}</td>
				</tr>
<!-- END no_auctions -->
			</table>
<!-- IF B_MULPAG -->
			<table width=100% cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td align="center">
						{L_5117} {PAGE} {L_5118} {PAGES}
						<br>
	<!-- IF B_NOTLAST -->
						<a href="{SITEURL}active_auctions.php?PAGE={PREV}&user_id={USER_ID}"><u>{L_5119}</u></a>&nbsp;&nbsp;
	<!-- ENDIF -->
						{PAGENA}
						&nbsp;&nbsp;
	<!-- IF B_NOTLAST -->
						<a href="{SITEURL}active_auctions.php?PAGE={NEXT}&user_id={USER_ID}"><u>{L_5120}</u></a>
	<!-- ENDIF -->
					</td>
				</tr>
			</table>
<!-- ENDIF -->
		</div>
	</div>
</div>