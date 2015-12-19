<!-- INCLUDE user_menu_header.tpl -->

<div class="row">
	<div class="col-md-12">
		<div class="well well-sm">
			<h4><span class="glyphicon glyphicon-user" aria-hidden="true"></span> {USERNICK} ({USERFB}) {USERFBIMG}</h4>
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
				<b><a href="{fbs.USFLINK}">{fbs.USERNAME} ({fbs.USFEED})</a></b>&nbsp;{fbs.USICON}
				<span class="text-muted"><small>({L_506}{fbs.FBDATE} {L_25_0177} {fbs.AUCTIONURL})</small></span>
				<br>
				<b>{L_504}: </b>{fbs.FEEDBACK}
			</td>
		</tr>
<!-- END fbs -->
	</table>
</div>
<div class="text-center">
	{PAGENATION}
</div>

<!-- INCLUDE user_menu_footer.tpl -->