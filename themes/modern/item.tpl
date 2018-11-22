<!-- IF B_COUNTDOWN -->
<script type="text/javascript">
$(document).ready(function() {
	var timeRemaining = {ENDS_IN};
	var endDateTime = new Date();
	endDateTime.setSeconds(endDateTime.getSeconds() + timeRemaining);
	function padLength(what)
	{
		var output = (what.toString().length == 1) ? '0' + what : what;
		return output;
	}
	function displayTime() {
		var currentDateTime = new Date();

		if (currentDateTime.getTime() < endDateTime.getTime()) {
			var remainingTime = Math.floor((endDateTime.getTime() - currentDateTime.getTime()) / 1000);
			var hours = Math.floor(remainingTime / 3600);
			var mins = Math.floor((remainingTime - (hours * 3600)) / 60);
			var secs = Math.floor(remainingTime - (hours * 3600) - (mins * 60));

			var timeString = padLength(hours) + ':' + padLength(mins) + ':' + padLength(secs);
			$('#ending_counter').html(timeString);
			setTimeout(displayTime, 1000);
		} else {
			$("#ending_counter").html('<div class="error-box">{L_911}</div>');
		}
	}
	setTimeout(displayTime, 1000);
});
</script>
<!-- ENDIF -->
<div class="row">
	<div class="col-md-12">
		<ul class="breadcrumb"><b>{L_041}:</b> {TOPCATSPATH}</ul>
		<div class="panel panel-default sm-padding" style="text-align: right;">
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
		<div class="alert alert-success" role="alert">
			{YOURBIDMSG}
		</div>
<!-- ENDIF -->
		<div class="row grid-padding">
			<div class="col-md-5 col-sm-5 grid-padding">
				<div class="item-title visible-xs text-capitalize">{TITLE}</div>
<!-- IF B_HASIMAGE -->
				<div class="main-gallery panel panel-default">
					<div class="panel-heading"><span class="label label-default">{L_113}: {ID}</span></div>
					<div class="panel-body">
						<div class="col-md-12">
							<img class="img-rounded img-responsive center-block" src="{SITEURL}getthumb.php?w=430&fromfile={PIC_URL}&auction_id={ID}" border="0" align="center" width="430px">
						</div>
	<!-- IF B_HASGALELRY -->
						<div>
							<a name="gallery"></a>
							<div id="gallery">
		<!-- BEGIN gallery -->
								<div class="col-md-4 col-xs-4 col-sm-4">
									<a href="{SITEURL}{UPLOADEDPATH}{ID}/{gallery.V}" title="" data-lightbox="gallery">
									<img class="img-rounded img-responsive" src="{SITEURL}getthumb.php?w={THUMBWIDTH}&fromfile={gallery.V}&auction_id={ID}" border="0"></a>
								</div>
		<!-- END gallery -->
							</div>
						</div>
	<!-- ENDIF -->
					</div>
					<div class="panel-footer">{L_611} <span style="color:#ff3300"><b>{AUCTION_VIEWS}</b></span> {L_612}</div>
				</div>
<!-- ELSE -->
				<div class="panel panel-default">
					<div class="panel-heading"><span class="label label-default">{L_113}: {ID}</span></div>
					<div class="panel-body">
						<img class="thumbnail img-responsive center-block" src="{SITEURL}/themes/{THEME}/img/no-picture-gallery.png" alt="no picture" width="430px" />
					</div>
					<div class="panel-footer">{L_611} <span style="color:#ff3300"><b>{AUCTION_VIEWS}</b></span> {L_612}</div>
				</div>
<!-- ENDIF -->
			</div>
			<div class="col-md-7 col-sm-7">
				<div class="item-title hidden-xs text-capitalize">{TITLE}</div>
<!-- IF B_CANEDIT -->
				<a class="btn btn-primary btn-xs" href="{SITEURL}edit_active_auction.php?id={ID}">{L_30_0069}</a>
<!-- ENDIF -->
				<div class="panel panel-default">
					<table class="table table-bordered table-condensed table-striped">
						<!-- auction type -->
						<tr>
							<td width="30%" align="left">{L_261}: </td>
							<td align="left">{AUCTION_TYPE}</td>
						</tr>
						<!-- higher bidder -->
<!-- IF B_HASBUYER and B_NOTBNONLY -->
						<tr>
							<td width='30%' style="leftpan" valign="top">{L_117}: </td>
							<td>
	<!-- BEGIN high_bidders -->
		<!-- IF B_BIDDERPRIV -->
								<b>{high_bidders.BUYER_NAME}</b>
		<!-- ELSE -->
								<a href="{SITEURL}profile.php?user_id={high_bidders.BUYER_ID}&amp;auction_id={ID}"><b>{high_bidders.BUYER_NAME}</b></a>
								<b>(<a href="{SITEURL}feedback.php?id={high_bidders.BUYER_ID}&amp;faction=show">{high_bidders.BUYER_FB}</a>)</b>
		<!-- ENDIF -->
								<img src="{SITEURL}images/icons/{high_bidders.BUYER_FB_ICON}" alt="{high_bidders.BUYER_FB_ICON}" class="fbstar">
	<!-- END high_bidders -->
							</td>
						</tr>
<!-- ENDIF -->
<!-- IF QTY gt 1 -->
						<tr>
							<td width="30%" align="left">{L_901}: </td>
							<td align="left">{QTY}</td>
						</tr>
<!-- ENDIF -->
						<tr>
							<td width="30%" align="left">{L_923}: </td>
							<td align="left">{COUNTRY}</td>
						</tr>
						<tr>
							<td width="30%" align="left">{L_118}: </td>
							<td align="left" valign="top">
<!-- IF B_COUNTDOWN -->
								<span id="ending_counter">{ENDS}</span>
<!-- ELSE -->
								{ENDS}<!-- IF B_SHOWENDTIME --><br><span class="text-muted"><small>({ENDTIME})</small></span><!-- ENDIF -->
<!-- ENDIF -->
							</td>
						</tr>
<!-- IF B_NOTBNONLY -->
						<tr>
							<td width="30%" align="left">{L_119}: </td>
							<td align="left">{NUMBIDS} {VIEW_HISTORY2}</td>
						</tr>
	<!-- IF ATYPE eq 2 -->
						<tr>
							<td width="30%" align="left">
								{L_038}:
							</td>
							<td align="left">{MINBID}</td>
						</tr>
	<!-- ENDIF -->
						<tr>
							<td width="30%" align="left">{L_116}: </td>
							<td align="left" valign="middle">{MAXBID}<!-- IF B_HASRESERVE -->&nbsp;<span class="text-muted"><small>{L_514}<small></span><!-- ENDIF --></td>
						</tr>
<!-- ENDIF -->
<!-- IF B_SHIPPING -->
						<tr>
							<td width="30%" align="left">{L_023}: </td>
							<td align="left">{SHIPPING_COST}</td>
						</tr>
<!-- ENDIF -->
<!-- IF (B_ADDITIONAL_SHIPPING_COST or B_BUY_NOW_ONLY) and B_SHOW_ADDITIONAL_SHIPPING_COST -->
						<tr>
							<td width="30%" align="left">{L_350_1008}: </td>
							<td align="left">{ADDITIONAL_SHIPPING_COST}</td>
						</tr>
<!-- ENDIF -->
<!-- IF B_BUY_NOW -->
						<tr>
							<td width="30%" align="left">{L_496}:</td>
							<td align="left">
								{BUYNOW2}
							</td>
						</tr>
<!-- ENDIF -->
<!-- IF B_HASENDED -->
						<tr>
							<td colspan="2" align="left"><b>{L_904}</b></td>
						</tr>
<!-- ENDIF -->
					</table>
				</div>
			</div>
			<div class="col-md-7 col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading"><b>{L_30_0209}</b></div>
					<div class="panel-body">
						<div>
							<a href='{SITEURL}profile.php?user_id={SELLER_ID}&amp;auction_id={ID}'><b>{SELLER_NICK}</b></a>
							(<a href='{SITEURL}feedback.php?id={SELLER_ID}&amp;faction=show'>{SELLER_TOTALFB}</A>)
							<!-- IF SELLER_FB_ICON ne '' --><img src="{SITEURL}images/icons/{SELLER_FB_ICON}" alt="{SELLER_FB_ICON}" class="fbstar"><!-- ENDIF -->
						</div>
						<div>
							<ul class="list-unstyled">
								<li>{L_5509}{SELLER_NUMFB}{L__0151}
								<li><b>{L_5506}{SELLER_FBPOS}</b>
<!-- IF SELLER_FBNEG ne 0 -->
								<li>{SELLER_FBNEG}</li>
<!-- ENDIF -->
								<li>{L_5508}{SELLER_REG}</li>
							</ul>
							<a href="{SITEURL}active_auctions.php?user_id={SELLER_ID}"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true" style="padding-right: 5px;"></span>{L_213}</a>
							<br><br>
						</div>
<!-- IF B_HASENDED eq false and B_CAN_BUY -->
						<div class="well well-sm">
							<div class="row">
	<!-- IF B_NOTBNONLY -->
								<form name="bid" action="{SITEURL}bid.php" method="post">
									<div class="form-group">
										<div class="col-md-3 col-md-offset-2">
		<!-- IF QTY gt 1 -->
											<input type="text" class="form-control" name="qty" placeholder="{L_284}"> {QTY} {L_5408}
		<!-- ENDIF -->
											<input type="text" class="form-control" name="bid" placeholder="{L_121}">
										</div>
									</div>
									<div class="col-md-5">
		<!-- IF ATYPE eq 1 -->
										<div class="bg-warning md-padding">{L_124}: {NEXTBID}</div><br>
		<!-- ENDIF -->
									</div>
									<div class="col-md-8 col-md-offset-2">
										<input type="hidden" name="seller_id" value="{SELLER_ID}">
										<input type="hidden" name="title" value="{TITLE}" >
										<input type="hidden" name="category" value="{CAT_ID}" >
										<input type="hidden" name="id" value="{ID}">
										<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
										<input type="submit" name="" value="{L_30_0208}" class="form-control btn btn-primary">
									</div>
								</form>
	<!-- ELSE -->
								<div class="col-md-8 col-md-offset-2">
									{BUYNOW} <a class="btn btn-success btn-block" href="{SITEURL}buy_now.php?id={ID}">{L_496}</a>
								</div>
	<!-- ENDIF -->
							</div>
						</div>
<!-- ENDIF -->
<!-- IF B_CAN_BUY eq false -->
						<div class="row">
							<div class="col-md-8 col-md-offset-2">
								<div class="alert alert-warning" role="alert">
									<span class="pull-left"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>  {L_5002}</span> <span class="pull-right"><a class="btn btn-warning btn-xs" href="{SITEURL}user_login.php?" class="alert-link">{L_221}</a></span>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
<!-- ENDIF -->
					</div>
				</div>
				<a class="report-item pull-right" href='{SITEURL}item_report.php?id={ID}'>{L_report_this_item}</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><a name="description"></a>{L_018}</h3>
					</div>
					<div class="panel-body">
						{AUCTION_DESCRIPTION}
					</div>
				</div>
<!-- IF B_HAS_QUESTIONS -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><a name="questions"></a>{L_552}</h3>
					</div>
					<div class="panel-body">
	<!-- BEGIN questions -->
						<span class="glyphicon glyphicon-comment" aria-hidden="true" style="padding-right: 10px;"></span>
						<div class="well well-sm">
		<!-- BEGIN conv -->
							<p><span class="text-muted"><small>{questions.conv.BY_WHO}:</small></span> {questions.conv.MESSAGE}</p>
		<!-- END conv -->
						</div>
	<!-- END questions -->
					</div>
				</div>
<!-- ENDIF -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">{L_724}</h3>
					</div>
					<div class="panel-body">
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
											<!-- IF SECCATSPATH ne '' --><b>{L_814}:</b> {SECCATSPATH}<!-- ENDIF -->
										</div>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>
<!-- IF B_SHOWHISTORY -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><a name="history"></a>{L_26_0001}</h3>
					</div>
					<div class="panel-body">
						<table class="table table-bordered table-striped table-condensed">
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
			</div>
		</div>
	</div>
</div>
