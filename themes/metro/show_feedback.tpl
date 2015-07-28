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
				<tr class="titTable2">
					<td width="5%">&nbsp;</td>
					<td width="40%">{L_503}</td>
					<td width="15%">{L_240}</td>
					<td width="15%">{L_259}</td>
					<td width="15%">{L_364}</td>
				</tr>
<!-- BEGIN fbs -->
				<tr {fbs.BGCOLOUR}>
					<td>
						<img src="{fbs.IMG}" align="middle" alt="">
					</td>
					<td>
						{fbs.FEEDBACK}
					</td>
					<td>
						<a href="{fbs.USFLINK}">{fbs.USERNAME}</a> (<a href="{SITEURL}feedback.php?id={fbs.USERID}&faction=show">{fbs.USFEED}</a>) {fbs.USICON}
					</td>
					<td>
						{fbs.AUCTIONURL}
					</td>
					<td>
						{fbs.FBDATE}
					</td>
				</tr>
<!-- END fbs -->
				<tr>
					<td align="center" colspan="5">{PAGENATION}</td>
				</tr>
			</table>
		</div>
	</div>
</div>