<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well">
			<legend>{L_208}</legend>
			<div class="col-md-12 grid-margin-btm-md">
				<a class="btn btn-default btn-xs" href="{SITEURL}item.php?id={AUCT_ID}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>{L_138}</a>
				<a class="btn btn-default btn-xs" href="{SITEURL}profile.php?user_id={ID}">{L_505}</a>
			</div>
			<div class="col-md-12">
				<div class="alert alert-info" role="alert">{L_185}{USERNICK} ({USERFB}) <!-- IF USER_FB_ICON ne '' --><img src="{SITEURL}images/icons/{USER_FB_ICON}" alt="{USER_FB_ICON}" class="fbstar"><!-- ENDIF --></div>
				<div class="panel panel-default visible-xs">
					<div class="panel-body">
						<legend>{L_503}</legend>
						<div class="row">
<!-- BEGIN fbs -->
							<div class="col-md-6 col-sm-6">
								<a href="{fbs.USFLINK}">{fbs.USERNAME}</a> (<a href="{SITEURL}feedback.php?id={fbs.USERID}&faction=show">{fbs.USFEED}</a>) {fbs.USICON}
							</div>
							<div class="col-md-6 col-sm-6">
								<small>{fbs.FBDATE}</small>
							</div>
							<div class="clearfix"></div>
							<div class="col-md-12">
								<img src="{fbs.IMG}" align="middle" alt=""> {fbs.FEEDBACK}<hr>
							</div>
<!-- END fbs -->
						</div>
					</div>
				</div>
				<table class="table hidden-xs">
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
							<a href="{fbs.USFLINK}">{fbs.USERNAME}</a> (<a href="{SITEURL}feedback.php?id={fbs.USERID}&faction=show">{fbs.USFEED}</a>) <!-- IF fbs.FB_ICON ne '' --><img src="{SITEURL}images/icons/{fbs.FB_ICON}" alt="{fbs.FB_ICON}" class="fbstar"><!-- ENDIF -->
						</td>
						<td>
							{fbs.AUCTIONURL}
						</td>
						<td>
							{fbs.FBDATE}
						</td>
					</tr>
<!-- END fbs -->
				</table>
				<div class="text-center"> {PAGENATION}</div>
			</div>
		</div>
	</div>
</div>
