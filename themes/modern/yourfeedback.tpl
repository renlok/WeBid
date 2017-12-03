<!-- INCLUDE user_menu_header.tpl -->

<div class="row">
	<div class="col-md-12">
		<div class="well well-sm">
			<h4><span class="glyphicon glyphicon-user" aria-hidden="true"></span> {USERNICK} ({USERFB}) <!-- IF USER_FB_ICON ne '' --><img src="{SITEURL}images/icons/{USER_FB_ICON}" alt="{USER_FB_ICON}" class="fbstar"><!-- ENDIF --></h4>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<table class="table table-bordered table-condensed table-striped">
<!-- BEGIN fbs -->
		<tr {fbs.BGCOLOUR}>
			<td>
				<img src="{fbs.IMG}" align="middle" alt="">
			</td>
			<td>
				<b><a href="{fbs.USFLINK}">{fbs.USERNAME} ({fbs.USFEED})</a></b> <!-- IF fbs.FB_ICON ne '' --><img src="{SITEURL}images/icons/{fbs.FB_ICON}" alt="{fbs.FB_ICON}" class="fbstar"><!-- ENDIF -->
				<span class="text-muted"><small>({L_506}{fbs.FBDATE} {L_25_0177}
		<!-- IF fbs.AUCTION_TITLE eq '' -->
				{L_113}{fbs.AUCTION_ID}
		<!-- ELSE -->
				<a href="item.php?id={fbs.AUCTION_ID}">{fbs.AUCTION_TITLE}</a>
		<!-- ENDIF -->
				)</small></span>
				<br>
				<b>{L_504}: </b>{fbs.FEEDBACK}
			</td>
		</tr>
<!-- END fbs -->
	</table>
</div>
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
