<div class="content">
	<div class="tableContent2">
		<div class="titTable2 rounded-top rounded-bottom">
			{L_206}
		</div>
<!-- IF B_VIEW -->
		<div class="titTable3">
<!-- IF B_AUCID -->
			<a href="{SITEURL}item.php?id={AUCTION_ID}">{L_138}</a> |
<!-- ENDIF -->
			<a href="{SITEURL}active_auctions.php?user_id={USER_ID}">{L_213}</a> |
			<a href="{SITEURL}closed_auctions.php?user_id={USER_ID}">{L_214}</a> |
<!-- IF B_CONTACT -->
			<a href="{SITEURL}email_request.php?user_id={USER_ID}&amp;username={USER}&amp;auction_id={AUCTION_ID}">{L_210}{USER}</a> |
<!-- ENDIF -->
			<a href="{SITEURL}feedback.php?id={USER_ID}&amp;faction=show">{L_208}</a>
		</div>
		<div class="padding">
			<div class="table2">
				<table width="100%" border="0" cellspacing="1" cellpadding="4">
					<tr>
						<td width="45%" valign="top">
							<b>{USER} ({SUM_FB})</b> <!-- IF FB_ICON ne '' --><img src="{SITEURL}images/icons/{FB_ICON}" alt="{FB_ICON}" class="fbstar"><!-- ENDIF --><br>
							{L_209} <b>{REGSINCE}</b><br>
							{L_240} <b>{COUNTRY}</b><br>
							{L_502} <b>{NUM_FB}</b><br>
							{FB_POS}
							{FB_NEUT}
							{FB_NEG}
						</td>
						<td valign="top">
							<table width="100%" border="0" cellspacing="2" cellpadding="3">
								<tr>
									<td colspan="4" class="titTable2">{L_385}</td>
								</tr>
								<tr>
									<td width="25%">&nbsp;</td>
									<td align="center" width="25%"><img src="{SITEURL}images/positive.png"></td>
									<td align="center" width="25%"><img src="{SITEURL}images/neutral.png"></td>
									<td align="center" width="25%"><img src="{SITEURL}images/negative.png"></td>
								</tr>
								<tr valign="top">
									<td colspan="4" bgcolor="#eeeeee"><img src="{SITEURL}images/transparent.gif" width="1" height="5"></td>
								</tr>
								<tr>
									<td>{L_386}</td>
									<td align="center" style="color:#009933">{FB_LASTMONTH_POS}</td>
									<td align="center">{FB_LASTMONTH_NEUT}</td>
									<td align="center" style="color:#FF0000">{FB_LASTMONTH_NEG}</td>
								</tr>
								<tr>
									<td>{L_387}</td>
									<td align="center" style="color:#009933">{FB_LAST3MONTH_POS}</td>
									<td align="center">{FB_LAST3MONTH_NEUT}</td>
									<td align="center" style="color:#FF0000">{FB_LAST3MONTH_NEG}</td>
								</tr>
								<tr>
									<td>{L_388}</td>
									<td align="center" style="color:#009933">{FB_LASTYEAR_POS}</td>
									<td align="center">{FB_LASTYEAR_NEUT}</td>
									<td align="center" style="color:#FF0000">{FB_LASTYEAR_NEG}</td>
								</tr>
								<tr valign="top">
									<td colspan="4" bgcolor="#eeeeee"><img src="{SITEURL}images/transparent.gif" width="1" height="5"></td>
								</tr>
								<tr>
									<td>{L_389}</td>
									<td align="center" style="color:#009933">{FB_SELLER_POS}</td>
									<td align="center">{FB_SELLER_NEUT}</td>
									<td align="center" style="color:#FF0000">{FB_SELLER_NEG}</td>
								</tr>
								<tr>
									<td>{L_390}</td>
									<td align="center" style="color:#009933">{FB_BUYER_POS}</td>
									<td align="center">{FB_BUYER_NEUT}</td>
									<td align="center" style="color:#FF0000">{FB_BUYER_NEG}</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
<!-- ELSE -->
			<div class="padding">{MSG}</div>
<!-- ENDIF -->
		</div>
	</div>
</div>
