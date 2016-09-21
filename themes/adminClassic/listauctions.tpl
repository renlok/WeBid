		<div style="width:25%; float:left;">
			<div style="margin-left:auto; margin-right:auto;">
				<!-- INCLUDE sidebar-{CURRENT_PAGE}.tpl -->
			</div>
		</div>
		<div style="width:75%; float:right;">
			<div class="main-box">
				<h4 class="rounded-top rounded-bottom">{L_239}&nbsp;&gt;&gt;&nbsp;{PAGE_TITLE}</h4>
				<div class="plain-box">{NUM_AUCTIONS} {L_311}<!-- IF B_SEARCHUSER --> {L_934}{USERNAME}<!-- ENDIF --></div>
				<table width="98%" cellpadding="0" cellspacing="0">
				<tr>
					<th align="center"><b>{L_017}</b></th>
					<th align="center"><b>{L_557}</b></th>
					<th align="left"><b>{L_297}</b></th>
				<tr>
				<!-- BEGIN auctions -->
				<tr {auctions.BG}>
					<td>
						<!-- IF auctions.SUSPENDED > 0 -->
						<span style="color:#FF0000">{auctions.TITLE}</span>
						<!-- ELSE -->
							<!-- IF auctions.TIMESREPORTED > 0 -->
							<span style="color:#FFA500">{auctions.TITLE}</span>
							<!-- ELSE -->
							{auctions.TITLE}
							<!-- ENDIF -->
						<!-- ENDIF -->
						<p>[ <a href="{SITEURL}item.php?id={auctions.ID}" target="_blank">{L_5295}</a> ]</p>
					</td>
					<td>
						<b>{L_003}:</b> {auctions.USERNAME}<br>
						<b>{L_625}:</b> {auctions.START_TIME}<br>
						<b>{L_626}:</b> {auctions.END_TIME}<br>
						<b>{L_041}:</b> {auctions.CATEGORY}
					</td>
					<td align="left">
						<a href="editauction.php?id={auctions.ID}&offset={PAGE}">{L_298}</a><br>
						<a href="deleteauction.php?id={auctions.ID}&offset={PAGE}">{L_008}</a><br>
						<a href="excludeauction.php?id={auctions.ID}&offset={PAGE}">
					<!-- IF auctions.SUSPENDED eq 0 -->
						{L_300}
					<!-- ELSE -->
						{L_310}
					<!-- ENDIF -->
						</a>
					<!-- IF auctions.IN_MODERATION_QUEUE -->
						<br><a href="removefrommoderation.php?id={auctions.ID}&offset={PAGE}">{L_moderator_dismiss}</a>
					<!-- ENDIF -->
					<!-- IF auctions.B_HASWINNERS -->
						<br><a href="viewwinners.php?id={auctions.ID}&offset={PAGE}">{L__0163}</a>
					<!-- ENDIF -->
					</td>
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