<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well">
			<legend>{L_206}</legend>
<!-- IF B_VIEW -->
			<div class="col-md-12 grid-padding">
<!-- IF B_AUCID -->
				<a class="btn btn-default btn-xs grid-margin-btm" href="{SITEURL}item.php?id={AUCTION_ID}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>{L_138}</a>
<!-- ENDIF -->
				<a class="btn btn-success btn-xs grid-margin-btm" href="{SITEURL}active_auctions.php?user_id={USER_ID}">{L_213}</a>
				<a class="btn btn-danger btn-xs grid-margin-btm" href="{SITEURL}closed_auctions.php?user_id={USER_ID}">{L_214}</a>
<!-- IF B_CONTACT -->
				<a class="btn btn-info btn-xs grid-margin-btm" href="{SITEURL}email_request.php?user_id={USER_ID}&amp;username={USER}&amp;auction_id={AUCTION_ID}">{L_210}{USER}</a>
<!-- ENDIF -->
				<a class="btn btn-warning btn-xs grid-margin-btm" href="{SITEURL}feedback.php?id={USER_ID}&amp;faction=show">{L_208}</a>
			</div>
			<div class="col-md-6">
				<h4><span style="margin-right: 10px;" class="glyphicon glyphicon-user" aria-hidden="true"></span>{USER} ({SUM_FB}) <!-- IF FB_ICON ne '' --><img src="{SITEURL}images/icons/{FB_ICON}" alt="{FB_ICON}" class="fbstar"><!-- ENDIF --></h4><br>
				<ul class="list-unstyled">
					<li>{L_209} <b>{REGSINCE}</b><br></li>
					<li>{L_240} <b>{COUNTRY}</b><br></li>
					<li>{L_502} <b>{NUM_FB}</b><br></li>
					<li>{FB_POS}</li>
					<li>{FB_NEUT}</li>
					<li>{FB_NEG}</li>
				</ul><br>
			</div>
			<div class="col-md-6">
				<h4>{L_385}</h4>
				<table class="table table-bordered">
					<tr>
						<td width="40%">&nbsp;</td>
						<td align="center" width="20%"><img src="{SITEURL}images/positive.png"></td>
						<td align="center" width="20%"><img src="{SITEURL}images/neutral.png"></td>
						<td align="center" width="20%"><img src="{SITEURL}images/negative.png"></td>
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
			</div>
<!-- ELSE -->
			<div class="padding">
				{MSG}
			</div>
<!-- ENDIF -->
		</div>
	</div>
</div>
