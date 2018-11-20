<!-- INCLUDE user_menu_header.tpl -->

<script type="text/javascript">
$(document).ready(function() {
	$("#deleteall").click(function() {
		var checked_status = this.checked;
		$("input[name='O_delete[]']").each(function() {
			this.checked = checked_status;
		});
	});
	$("#processdel").submit(function() {
		if (confirm('{L_30_0087}'))
		{
			return true;
		}
		else
		{
			return false;
		}
	});
});
</script>
<!-- IF USER_MESSAGE ne '' -->
<div class="success-box">{USER_MESSAGE}</div>
<!-- ENDIF -->
<form name="open" method="post" action="" id="processdel">
	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
	<dl class="tabs">
		<dd><a href="yourauctions.php">{L_619}</a></dd>
		<dd><a href="yourauctions_p.php">{L_25_0115}</a></dd>
		<dd><a href="yourauctions_c.php">{L_204}</a></dd>
		<dd class="active"><a href="yourauctions_s.php">{L_2__0056}</a></dd>
		<dd><a href="yourauctions_sold.php">{L_25_0119}</a></dd>
	</dl>
	<table width="100%" border="0" cellspacing="1" cellpadding="4" align="center">
		<tr>
			<td class="titTable1">
				<a href="yourauctions_s.php?sa_ord=title&sa_type={ORDERNEXT}">{L_624}</a>
<!-- IF ORDERCOL eq 'title' -->
				<a href="yourauctions_s.php?sa_ord=title&sa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
			</td>
			<td class="titTable1" width="9%" align="center">
				{L__0153}
			</td>
			<td class="titTable1" width="7%" align="center">
				<a href="yourauctions_s.php?sa_ord=num_bids&sa_type={ORDERNEXT}">{L_627}</a>
<!-- IF ORDERCOL eq 'num_bids' -->
				<a href="yourauctions_s.php?sa_ord=num_bids&sa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
			</td>
			<td class="titTable1" width="10%" align="center">
				<a href="yourauctions_s.php?sa_ord=current_bid&sa_type={ORDERNEXT}">{L_628}</a>
<!-- IF ORDERCOL eq 'current_bid' -->
				<a href="yourauctions_s.php?sa_ord=current_bid&sa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
			</td>
			<td class="titTable1" width="6%" align="center">
				{L_298}
			</td>
			<td class="titTable1" width="8%" align="center">
				{L_008}
			</td>
			<td class="titTable1" width="15%">&nbsp;</td>
		</tr>
<!-- IF B_AREITEMS -->
	<!-- BEGIN items -->
		<tr {items.BGCOLOUR}>
			<td>
				<a href="item.php?id={items.ID}">{items.TITLE}</a>
			</td>
			<td width="9%"  align="center">
		<!-- IF items.RELIST eq 0 -->
				--
		<!-- ELSE -->
				{items.RELIST} / {items.RELISTED}
		<!-- ENDIF -->
			</td>
			<td width="7%" align="center">
				{items.BIDS}
			</td>
			<td width="10%" align="center">
		<!-- IF items.B_HASNOBIDS -->
				-
		<!-- ELSE -->
				{items.BID}
		<!-- ENDIF -->
			</td>
			<td width="6%" align="center">
		<!-- IF items.B_HASNOBIDS -->
				<a href="edit_active_auction.php?id={items.ID}"><img src="images/edititem.gif" width="13" height="17" alt="{L_512}" border="0"></a>
		<!-- ENDIF -->
			</td>
			<td width="8%" align="center">
		<!-- IF items.B_HASNOBIDS -->
				<input type="checkbox" name="O_delete[]" value="{items.ID}">
		<!-- ENDIF -->
			</td>
			<td align="center">
		<!-- IF items.SUSPENDED eq 9 -->
				<a href="{SITEURL}pay.php?a=4&auction_id={items.ID}">{L_769}</a>
		<!-- ELSEIF items.SUSPENDED eq 8 -->
				<a href="{SITEURL}pay.php?a=5">{L_770}</a>
		<!-- ENDIF -->
			</td>
		</tr>
	<!-- END items -->
<!-- ENDIF -->
		<tr {BGCOLOUR}>
			<td colspan="5" align="right">{L_30_0102}</td>
			<td align="center"><input type="checkbox" id="deleteall"></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td class="white" colspan="7" align="center">
				<input type="hidden" name="action" value="delopenauctions">
				<input type="submit" name="Submit" value="{L_631}"  class="button">
			</td>
		</tr>
	</table>
</form>
<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td align="center">
			{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
			<br>
			{PREV}
<!-- BEGIN pages -->
			{pages.PAGE}&nbsp;&nbsp;
<!-- END pages -->
			{NEXT}
		</td>
	</tr>
</table>

<!-- INCLUDE user_menu_footer.tpl -->
