<!-- INCLUDE user_menu_header.tpl -->

<!-- BEGIN items -->
<div class="panel panel-default">
	<div class="panel-heading">
		{L_458} <b><a href="item.php?id={items.AUC_ID}" target="_blank">{items.TITLE}</a></b>
		<small>ID: <a href="item.php?id={items.AUC_ID}" target="_blank">{items.AUC_ID}</a> - {L_25_0121} {items.ENDS}</small>
	</div>
	<div class="panel-body">
		<small>{L_125}:</small> {items.SELLNICK}&nbsp;&nbsp;<span class="label label-info">{items.FB_LINK}</span><br>
		<small>{L_460}:</small> <a href="mailto:{items.SELLEMAIL}">{items.SELLEMAIL}</a><br>
		<small>{L_461}:</small> {items.FBID}<br>
		<small>{L_284}:</small> {items.QTY}<br>
		<small>{L_189}:</small> {items.TOTAL}<br>
<!-- IF items.SHIPPED eq 0 -->
		<img src="{SITEURL}images/clock.png"> <span class="smallspan">{L_1107}</span>
	<!-- ELSEIF items.SHIPPED eq 1 -->
		<img src="{SITEURL}images/lorry_go.png" border="0"> <span class="smallspan"><a href="{SITEURL}buying.php?shipped={items.ID}">{L_1108}</a></span>
	<!-- ELSEIF items.SHIPPED eq 2 -->
		<img src="{SITEURL}images/box.png" border="0"> <span class="smallspan">{L_1109}</span>
	<!-- ENDIF -->
		<div class="text-right">
		<!-- IF items.B_PAID -->
			<span class="label label-success">{L_755}</span>
	<!-- ELSE -->
			<form name="" method="post" action="{SITEURL}pay.php?a=2" id="fees">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<input type="hidden" name="pfval" value="{items.ID}">
				<input type="submit" name="Pay" value="{L_756}" class="btn btn-primary btn-sm">
			</form>
	<!-- ENDIF -->
		</div>
	</div>
</div>
<!-- END items -->
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
