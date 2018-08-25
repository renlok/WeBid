	<div style="width:25%; float:left;">
		<div style="margin-left:auto; margin-right:auto;">
			<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
		</div>
	</div>
	<div style="width:75%; float:right;">
		<div class="container">
			<h4 class="rounded-top rounded-bottom">{L_239}&nbsp;&gt;&gt;&nbsp;{PAGE_TITLE}</h4>
			<div class="plain-box">{NUM_AUCTIONS} {L_315}</div>
			<table class="table table-striped table-bordered">
				<tr>
					<th align="center"><b>{L_report_number}</b></th>
					
					<th align="center"><b>{L_reported_item}</b></th>
					<th align="center"><b>{L_reported_auction_details}</b></th>
					<th align="center"><b>{L_report_details}</b></th>
					
					<th align="left"><b>{L_297}</b></th>
				<tr>
				<!-- BEGIN auctions -->
					<!-- IF auctions.DISMISSED ne 1 -->
						<tr<!-- IF auctions.S_ROW_COUNT % 2 == 1 --> class="bg"<!-- ENDIF -->>
							<td align="center">
									<span style="color:#000"><b>{auctions.REPORTCOUNTER}</b></span>
							</td>
							<td>
								<!-- IF auctions.SUSPENDED eq 1 -->
								<span style="color:#FF0000"><b>{auctions.TITLE}</b> [ <a href="{SITEURL}item.php?id={auctions.ID}" target="_blank">{L_5295}</a> ]</span>
								<!-- ELSE -->
								<span style="color:#FFF000"><b>{auctions.TITLE}</b> [ <a href="{SITEURL}item.php?id={auctions.ID}" target="_blank">{L_5295}</a> ]</span>
								<!-- ENDIF -->
							</td>
							<td>
								<b>{L_username}:</b> {auctions.SELLERNAME}<br>
								<b>{L_625}:</b> {auctions.START_TIME}<br>
								<b>{L_626}:</b> {auctions.END_TIME}<br>
								<b>{L_041}:</b> {auctions.CATEGORY}
							</td>
							<td>
								<span style="color:#000"><b>{L_reported_by}</b> {auctions.REPORTERNAME}</span><br>
								<span><b>{L_reason_for_report}</b> {auctions.REASONGIVEN}</span>
							</td>
							
							<td align="left">
								<a href="editauction.php?id={auctions.ID}&offset={PAGE}">{L_298}</a><br>
								<a href="deleteauction.php?id={auctions.ID}&offset={PAGE}">{L_008}</a><br>
								<a href="dismissreport.php?id={auctions.REPORTID}&offset={PAGE}">{L_dismiss_report}</a><br>
								<a href="excludeauction.php?id={auctions.ID}&offset={PAGE}">
									<!-- IF auctions.SUSPENDED eq 1 -->
										{L_310}
									<!-- ELSE -->
										{L_300}
									<!-- ENDIF --></a>
							</td>
						</tr>
						<!-- ENDIF -->
					</tr>
					
				<!-- END auctions -->
			</table>
			<table class="table table-striped table-bordered">
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
		</div>
	</div>
