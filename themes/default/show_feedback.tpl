<div class="content">
	<div class="tableContent2">
		<div class="titTable2">
			{L_208}
		</div>
		<div class="titTable3">
			<a href="{SITEURL}item.php?id={AUCT_ID}">{L_138}</a> |
			<a href="{SITEURL}profile.php?user_id={ID}">{L_505}</a>
		</div>
		<div class="table2">
			<table border="0" width="100%" cellspacing="0" cellpadding="4">
				<tr>
					<td colspan=5>
						{L_185}{USERNICK} ({USERFB}) {USERFBIMG}
						<br>
						<br>
					</td>
				</tr>
				<tr>
					<td width="5%" class="titTable2">&nbsp;</td>
					<td width="40%" class="titTable2">{L_503}</td>
					<td width="15%" class="titTable2">{L_240}</td>
					<td width="15%" class="titTable2">{L_259}</td>
					<td width="15%" class="titTable2">{L_364}</td>
				</tr>
<!-- BEGIN fbs -->
				<tr {fbs.BGCOLOUR}>
					<td valign="top" width="5%">
						<img src="{fbs.IMG}" align="middle" alt="">
					</td>
					<td valign="top" width="40%">
						{fbs.FEEDBACK}
					</td>
					<td valign="top" width="15%">
						<a href="{fbs.USFLINK}">{fbs.USERNAME}</a> (<a href="{SITEURL}feedback.php?id={fbs.USERID}&faction=show">{fbs.USFEED}</a>) {fbs.USICON}
					</td>
					<td valign="top" width="15%">
						{fbs.AUCTIONURL}
					</td>
					<td valign="top" width="15%">
						{fbs.FBDATE}
					</td>
				</tr>
<!-- END fbs -->
				<tr>
					<td align="right" width="5%">{PAGENATION}</td>
				</tr>
			</table>
		</div>
	</div>
</div>