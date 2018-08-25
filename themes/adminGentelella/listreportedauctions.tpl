	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                                <div class="x_title">
                                    <h2>{L_239} <i class="fa fa-angle-double-right"></i> {PAGE_TITLE}</h2>
                                    <div class="clearfix"></div>
                                </div>
			<div class="col-md-12">
				<div class="main-box">
					<div class="plain-box">{NUM_AUCTIONS} {L_315}</div>
			<table class="table table-bordered table-striped">
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
								<span><b>{L_reported_by}</b> {auctions.REPORTERNAME}</span><br>
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
			<table width="98%" cellpadding="0" cellspacing="0" class="blank">
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
        </div>
        </div>
<!-- INCLUDE footer.tpl -->