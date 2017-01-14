<!-- IF B_COUNTDOWN -->
<script type="text/javascript">
$(document).ready(function() {
	var currenttime = '{ENDS_IN}';
	function padlength(what)
	{
		return (what.toString().length == 1)? '0' + what : what;
	}
	function displaytime()
	{
		currenttime -= 1;
		if (currenttime > 0)
		{
			var hours = Math.floor(currenttime / 3600);
			var mins = Math.floor((currenttime - (hours * 3600)) / 60);
			var secs = Math.floor(currenttime - (hours * 3600) - (mins * 60));
			var timestring = padlength(hours) + ':' + padlength(mins) + ':' + padlength(secs);
			$("#ending_counter").html(timestring);
			setTimeout(displaytime, 1000);
		}
		else
		{
			$("#ending_counter").html('<div class="error-box">{L_911}</div>');
		}
	}
	setTimeout(displaytime, 1000);
});
</script>
<!-- ENDIF -->
<div class="content">
	<div class="tableContent2">
		<div class="padding"><b>{L_041}:</b> {TOPCATSPATH}</div>
		<div class="titTable2 rounded-top rounded-bottom">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						{TITLE}
<!-- IF SUBTITLE ne '' -->
						<p class="smallspan">{SUBTITLE}</p>
<!-- ENDIF -->
					</td>
					<td align="right">{L_113}: {ID}</td>
				</tr>
<!-- IF B_CANEDIT -->
				<tr>
					<td colspan="2">
						[<a href="{SITEURL}edit_active_auction.php?id={ID}">{L_30_0069}</a>]
					</td>
				</tr>
<!-- ENDIF -->
			</table>
		</div>
		<div class="titTable3">
			{VIEW_HISTORY1}
			<a href="{SITEURL}friend.php?id={ID}">{L_106}</a> |
<!-- IF B_CANCONTACTSELLER -->
			<a href="{SITEURL}send_email.php?auction_id={ID}">{L_922}</a> |
<!-- ENDIF -->
<!-- IF B_LOGGED_IN -->
			<a href="{SITEURL}item_watch.php?{WATCH_VAR}={ID}">{WATCH_STRING}</a>
<!-- ELSE -->
			<a href="{SITEURL}user_login.php?">{L_5202}</a>
<!-- ENDIF -->
		</div>
<!-- IF B_USERBID -->
		<div class="{YOURBIDCLASS}">
			{YOURBIDMSG}
		</div>
<!-- ENDIF -->
		<br>
		<div class="table2">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="titTable5" valign="top">
						<table width="100%" border="0" cellpadding="5" cellspacing="0">
							<tr>
<!-- IF B_HASIMAGE -->
								<td width="10%" valign="top">
									<table bgcolor="#ffffff">
										<tr>
											<td align='center'>
												<img src="{SITEURL}getthumb.php?w={THUMBWIDTH}&fromfile={PIC_URL}" border="0" align="center"><br>
	<!-- IF B_HASGALELRY -->
												<a href="#gallery"><img src="{SITEURL}images/gallery.gif" border="0" alt="gallery"> {L_694}</a>
	<!-- ENDIF -->
											</td>
										</tr>
									</table>
								</td>
<!-- ENDIF -->
								<td width="60%" valign="top">
									<table width="100%" align="center" cellpadding="0" cellspacing="0" valign="top" border="0">
										<tr>
											<td>&nbsp;</td>
											<td align="left" valign="top">
												{L_611} <font color="#ff3300"><b>{AUCTION_VIEWS}</b></font> {L_612}<br>
												<a href="#description"><img src="{SITEURL}images/info.gif" border='0'></a>
												<a href="#description">{L_018}</a> &nbsp;&nbsp;&nbsp;
												<table border='0' width="100%" cellspacing="0" cellpadding="1">
						<!-- auction type -->
													<tr>
														<td width="50%" align="left">{L_261}: </td>
														<td align="left">{AUCTION_TYPE}</td>
													</tr>
						<!-- higher bidder -->
<!-- IF B_HASBUYER and B_NOTBNONLY -->
													<tr>
														<td width='50%' valign="top">
															{L_117}:
														</td>
														<td>
	<!-- BEGIN high_bidders -->
															<p>
		<!-- IF B_BIDDERPRIV -->
																<b>{high_bidders.BUYER_NAME}</b>
		<!-- ELSE -->
																<a href="{SITEURL}profile.php?user_id={high_bidders.BUYER_ID}&auction_id={ID}"><b>{high_bidders.BUYER_NAME}</b></a>
																<b>(<a href="{SITEURL}feedback.php?id={high_bidders.BUYER_ID}&faction=show">{high_bidders.BUYER_FB}</a>)</b>
		<!-- ENDIF -->
																<img src="{SITEURL}images/icons/{high_bidders.BUYER_FB_ICON}" alt="{high_bidders.BUYER_FB_ICON}" class="fbstar">
															</p>
	<!-- END high_bidders -->
														</td>
													</tr>
<!-- ENDIF -->
<!-- IF QTY gt 1 -->
													<tr>
														<td width="50%" align="left">{L_901}: </td>
														<td align="left">{QTY}</td>
													</tr>
<!-- ENDIF -->
													<tr>
														<td width="50%" align="left">{L_923}: </td>
														<td align="left">{COUNTRY}</td>
													</tr>
													<tr>
														<td width="50%" align="left">{L_118}: </td>
														<td align="left" valign="top">
<!-- IF B_COUNTDOWN -->
															<span id="ending_counter">{ENDS}</span>
<!-- ELSE -->
															{ENDS}<!-- IF B_SHOWENDTIME --><br><span class="smallspan">({ENDTIME})</span><!-- ENDIF -->
<!-- ENDIF -->
														</td>
													</tr>
<!-- IF B_NOTBNONLY -->
													<tr>
														<td width="50%" align="left">{L_119}: </td>
														<td align="left">{NUMBIDS} {VIEW_HISTORY2}</td>
													</tr>
	<!-- IF ATYPE eq 2 -->
													<tr>
														<td width="50%" align="left">
															{L_038}:
														</td>
														<td align="left">{MINBID}</td>
													</tr>
	<!-- ENDIF -->
													<tr>
														<td width="50%" align="left">{L_116}: </td>
														<td align="left" valign="middle">{MAXBID}<!-- IF B_HASRESERVE -->&nbsp;<span class="smallspan">{L_514}</span><!-- ENDIF --></td>
													</tr>
<!-- ENDIF -->
<!-- IF B_SHIPPING -->
													<tr>
														<td width="50%" align="left">{L_023}: </td>
														<td align="left">{SHIPPING_COST}</td>
													</tr>
<!-- ENDIF -->
<!-- IF (B_ADDITIONAL_SHIPPING_COST or B_BUY_NOW_ONLY) and B_SHOW_ADDITIONAL_SHIPPING_COST -->
													<tr>
														<td width="50%" align="left">{L_350_1008}: </td>
														<td align="left">{ADDITIONAL_SHIPPING_COST}</td>
													</tr>
<!-- ENDIF -->
<!-- IF B_BUY_NOW -->
													<tr>
														<td width="50%" align="left">{L_496}:</td>
														<td align="left">{BUYNOW2}</td>
													</tr>
<!-- ENDIF -->
<!-- IF B_HASENDED -->
													<tr>
														<td colspan="2" align="left"><b>{L_904}</b></td>
													</tr>
<!-- ENDIF -->
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
					<td width="2%">&nbsp;</td>
					<td width="37%" valign="top" bgcolor="#ffffff" align="left">
						<div class="titTable1">
							<b>{L_30_0209}</b>
						</div>
						<table width="100%" cellspacing="0" cellpadding="4" border="0" bgcolor="#ffffff">
							<tr>
								<td width="3%" class='table2'>&nbsp;</td>
								<td class="table2" style="padding:10px;">
									<a href='{SITEURL}profile.php?user_id={SELLER_ID}&auction_id={ID}'><b>{SELLER_NICK}</b></a>
									(<a href='{SITEURL}feedback.php?id={SELLER_ID}&faction=show'>{SELLER_TOTALFB}</a>)
									<!-- IF SELLER_FB_ICON ne '' --><img src="{SITEURL}images/icons/{SELLER_FB_ICON}" alt="{SELLER_FB_ICON}" class="fbstar"><!-- ENDIF -->
								</td>
							</tr>
							<tr>
								<td width="3%">&nbsp;</td>
								<td width="97%">
									<li>{L_5509}{SELLER_NUMFB}{L__0151}
									<li><b>{L_5506}{SELLER_FBPOS}</b>
<!-- IF SELLER_FBNEG ne 0 -->
									<li>{SELLER_FBNEG}</li>
<!-- ENDIF -->
									<li>{L_5508}{SELLER_REG}</li>
								</td>
							</tr>
							<tr>
								<td width="3%">&nbsp;</td>
								<td width="97%">
									<a href="{SITEURL}active_auctions.php?user_id={SELLER_ID}">{L_213}</a>
									<br><br>
								</td>
							</tr>
						</table>
						<div class="titTable1">
<!-- IF B_HASENDED eq false and B_CAN_BUY -->
	<!-- IF B_NOTBNONLY -->
							<table width="100%" border=0 cellpadding=2 cellspacing=0 border=1>
								<form name="bid" action="{SITEURL}bid.php" method="post">
									<tr>
										<td width="65%">
											<table width=100% border=0 cellpadding=2 cellspacing=0>
												<tr>
													<td align="left">
														<b>
		<!-- IF QTY gt 1 -->
														{L_284}: <input type="text" name="qty" size=15 /> {QTY} {L_5408}<br>
		<!-- ENDIF -->
														{L_121} <input type="text" name="bid" size="15">
		<!-- IF ATYPE eq 1 -->
														{L_124}: {NEXTBID}
														<br>
		<!-- ENDIF -->
													</td>
												</tr>
											</table>
										</td>
										<td valign='center' align='center' class='tema' width="50%">
											<input type="hidden" name="seller_id" value="{SELLER_ID}">
											<input type="hidden" name="title" value="{TITLE}" >
											<input type="hidden" name="category" value="{CAT_ID}" >
											<input type="hidden" name="id" value="{ID}">
											<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
											<input type="submit" name="" value="{L_30_0208}" class="button">
										</td>
									</tr>
								</form>
							</table>
	<!-- ELSE -->
							{BUYNOW} <a href="{SITEURL}buy_now.php?id={ID}"><img border="0" align="absbottom" alt="{L_496}" src="{BNIMG}"></a>
	<!-- ENDIF -->
<!-- ENDIF -->
<!-- IF B_CAN_BUY eq false -->
							<p>{L_5002}</p>
							<p><a href="{SITEURL}user_login.php?">{L_221}</a></p>
<!-- ENDIF -->
						</div>
						<a class="report-item rightside" href='{SITEURL}item_report.php?id={ID}'>{L_report_this_item}</a>
					</td>
				</tr>
			</table>
			<br>
			<div class="tableContent2">
				<div class="titTable4">
					<a name="description"></a>{L_018}
				</div>
				<div class="table2">{AUCTION_DESCRIPTION}</div>
			</div>
<!-- IF B_HAS_QUESTIONS -->
			<div class="tableContent2">
				<div class="titTable4">
					<a name="questions"></a>{L_552}
				</div>
				<div class="table2">
	<!-- BEGIN questions -->
					<div class="smallspan padding">
		<!-- BEGIN conv -->
					<p><b>{questions.conv.BY_WHO}</b>: {questions.conv.MESSAGE}</p>
<!-- END conv -->
					</div>
<!-- END questions -->
				</div>
			</div>
<!-- ENDIF -->
<!-- IF B_HASGALELRY -->
			<div class="tableContent2">
				<div class="titTable4">
					<a name="gallery"></a>{L_663}
				</div>
				<div class="table2" style="text-align:center; overflow-y:auto;" id="gallery">
					<table>
						<tr>
	<!-- BEGIN gallery -->
							<td>
								<a href="{SITEURL}{UPLOADEDPATH}{ID}/{gallery.V}" title="" data-lightbox="gallery">
									<img src="{SITEURL}getthumb.php?w={THUMBWIDTH}&fromfile={UPLOADEDPATH}{ID}/{gallery.V}" border="0" hspace="10">
								</a>
							</td>
	<!-- END gallery -->
						</tr>
					</table>
				</div>
			</div>
<!-- ENDIF -->
<!-- IF B_SHOWHISTORY -->
			<div class="tableContent2">
				<div class="titTable4">
					{L_26_0001}
				</div>
				<div class="table2">
					<a name="history"></a>
					<table width="100%" border="0" cellpadding="4" cellspacing="1">
						<tr>
							<th width="33%" align="center">{L_176}</th>
							<th width="33%" align="center">{L_130}</th>
							<th width="33%" align="center">{L_175}</th>
	<!-- IF ATYPE eq 2 -->
							<th width="33%" align="center">{L_284}</th>
	<!-- ENDIF -->
						</tr>
	<!-- BEGIN bidhistory -->
						<tr valign="top" {bidhistory.BGCOLOUR}>
							<td>
		<!-- IF B_BIDDERPRIV -->
								{bidhistory.NAME}
		<!-- ELSE -->
								<a href="{SITEURL}profile.php?user_id={bidhistory.ID}">{bidhistory.NAME}</a>
		<!-- ENDIF -->
							</td>
							<td align="center">
								{bidhistory.BID}
							</td>
							<td align="center">
								{bidhistory.WHEN}
							</td>
		<!-- IF ATYPE eq 2 -->
							<td align="center">
								{bidhistory.QTY}
							</td>
		<!-- ENDIF -->
						</tr>
	<!-- END bidhistory -->
					</table>
				</div>
			</div>
<!-- ENDIF -->
			<br>
			<div class="titTable4">{L_724}</div>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<div class="tableContent2">
							<div class="table2">
<!-- IF CITY ne '' or COUNTRY ne '' or ZIP ne '' -->
								<b>{L_014}:</b> <!-- IF CITY ne '' -->{CITY}<!-- ENDIF --> <!-- IF COUNTRY ne '' -->{COUNTRY}<!-- ENDIF --> <!-- IF ZIP ne '' -->({ZIP})<!-- ENDIF --><br>
<!-- ENDIF -->
<!-- IF B_SHIPPING -->
								<b>{L_025}:</b> {SHIPPING}, {INTERNATIONAL}<br>
<!-- ENDIF -->
<!-- IF SHIPPINGTERMS ne '' -->
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td valign="top"><b>{L_25_0215}:</b>&nbsp;</td>
										<td valign="top">{SHIPPINGTERMS}</td>
									</tr>
								</table>
<!-- ENDIF -->
								<br>
								<b>{L_026}:</b> {PAYMENTS}<br>
<!-- IF ! B_BUY_NOW_ONLY -->
								<b><!-- IF ATYPE eq 1 -->{L_127}<!-- ELSE -->{L_038}<!-- ENDIF -->:</b> {MINBID}<br>
<!-- ENDIF -->
								<br>
								<b>{L_111}:</b> {STARTTIME}<br>
								<b>{L_112}:</b> {ENDTIME}<br>
								<b>{L_113}:</b> {ID}<br>
								<br>
								<b>{L_041}:</b> {CATSPATH}<br>
<!-- IF SECCATSPATH ne '' -->
								<b>{L_814}:</b> {SECCATSPATH}
<!-- ENDIF -->
							</div>
						</div>
					</td>
				</tr>
			</table>
		<br>
		</div>
	</div>
</div>
