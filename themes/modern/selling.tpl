<!-- INCLUDE user_menu_header.tpl -->
<!-- BEGIN a -->
<div class="panel panel-default">
	<div class="panel-heading">
		<a href="{SITEURL}item.php?id={a.AUCTIONID}" target="_blank">{a.TITLE}</a> <small><span class="text-muted"> (ID: <a href="{SITEURL}item.php?id={a.AUCTIONID}" target="_blank">{a.AUCTIONID}</a> - {L_25_0121} {a.ENDS})</span></small>
	</div>
	<div class="panel-body">
		<div class="col-md-8 col-sm-7">
			<p>
				<small><span class="text-muted">{L_455}:</span></small> <a href="{SITEURL}profile.php?user_id={a.WINNERID}&auction_id={a.AUCTIONID}">{a.NICK}</a> {a.FB}<br>
				<small><span class="text-muted">{L_457}:</span></small> {a.BIDF}<br>
				<small><span class="text-muted">{L_284}:</span></small> {a.QTY}
			</p>
		</div>
		<div class="col-md-4 col-sm-5 text-right">
			<form name="" method="post" action="{SITEURL}order_packingslip.php" id="fees" target="_blank">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<input type="hidden" name="pfval" value="{a.AUCTIONID}">
				<input type="hidden" name="pfwon" value="{a.ID}">
				<input type="hidden" name="user_id" value="{SELLER_ID}">
				<input type="submit" type="button" class="btn btn-default btn-xs" value="{L_1106}">
<!-- IF a.B_PAID -->
				<span class="btn btn-success btn-xs">{L_898}</span>
<!-- ELSE -->
				<a class="btn btn-warning btn-xs" href="{SITEURL}selling.php?paid={a.ID}{AUCID}">{L_899}</a>
<!-- ENDIF -->
			</form>
<!-- IF a.SHIPPED eq 0 -->
			<img src="{SITEURL}images/clock.png"> <span class="smallspan"><a href="{SITEURL}selling.php?shipped={a.ID}{AUCID}">{L_1116}</a></span>
	<!-- ELSEIF a.SHIPPED eq 1 -->
			<img src="{SITEURL}images/lorry_go.png" border="0"> <span class="smallspan">{L_1117}</span>
	<!-- ELSEIF a.SHIPPED eq 2 -->
			<img src="{SITEURL}images/box.png" border="0"> <span class="smallspan">{L_1109}</span>
	<!-- ENDIF -->
		</div>
	</div>
</div>
<!-- END a -->
<!-- IF NUM_WINNERS eq 0 -->
<div class="alert alert-danger" role="alert">
	{L_198}
</div>
<!-- ENDIF -->

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="center">
			<small><span class="text-muted">{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}</span></small>
			<nav>
				<ul class="pagination">
					<br>
					<li>{PREV}</li>
<!-- BEGIN pages -->
					<li>{pages.PAGE}</li>
<!-- END pages -->
					<li>{NEXT}</li>
				</ul>
			</nav>
		</td>
	</tr>
</table>

<!-- INCLUDE user_menu_footer.tpl -->
