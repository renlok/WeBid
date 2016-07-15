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
						<!-- IF auctions.SUSPENDED eq 1 -->
						<span style="color:#FF0000">{auctions.TITLE}</span>
						<!-- ELSEIF auctions.SUSPENDED eq 2 -->
						<span style="color:#B000F0">{auctions.TITLE}</span>
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
						
					<!-- IF auctions.SUSPENDED eq 0 -->
						<a href="excludeauction.php?id={auctions.ID}&offset={PAGE}">{L_300}
					<!-- ELSEIF auctions.SUSPENDED eq 1 -->
						<a href="excludeauction.php?id={auctions.ID}&offset={PAGE}">{L_310}
					<!-- ELSE -->
						<a href="excludeauction.php?id={auctions.ID}&offset={PAGE}">{L_moderator_approve}
					<!-- ENDIF -->
						</a>
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