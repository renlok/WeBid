<!-- INCLUDE user_menu_header.tpl -->

<script type="text/javascript">
$(document).ready(function() {
	var relist_fee = {RELIST_FEE};
	$("#processrelist").submit(function() {
		if (confirm('{L_30_0087}')){
			return true;
		} else {
			return false;
		}
	});
	$("#relistid").click(function(){
		if (this.is(':checked'))
			$("#to_pay").text(parseFloat($("#to_pay").text()) - relist_fee);
		else
			$("#to_pay").text(parseFloat($("#to_pay").text()) + relist_fee);
	});
});
</script>

<form name="closed" method="post" action="" id="processrelist">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td align="right">
			<dl class="tabs">
				<dd><a href="yourauctions_p.php">{L_25_0115}</a></dd>
				<dd><a href="yourauctions.php">{L_619}</a></dd>
				<dd><a href="yourauctions_c.php">{L_204}</a></dd>
				<dd><a href="yourauctions_s.php">{L_2__0056}</a></dd>
			</dl>
		</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="4" align="center">
	<tr bgcolor="{TBLHEADERCOLOUR}">
		<td class="titTable1" width="40%">
			<a href="yourauctions_sold.php?solda_ord=title&solda_type={ORDERNEXT}">{L_624}</a>
<!-- IF ORDERCOL eq 'title' -->
			<a href="yourauctions_sold.php?solda_ord=title&solda_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
		</td>
		<td class="titTable1" width="10%">
			<a href="yourauctions_sold.php?solda_ord=starts&solda_type={ORDERNEXT}">{L_625}</a>
<!-- IF ORDERCOL eq 'starts' -->
			<a href="yourauctions_sold.php?solda_ord=starts&solda_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
		</td>
		<td class="titTable1" width="10%">
			<a href="yourauctions_sold.php?solda_ord=ends&solda_type={ORDERNEXT}">{L_626}</a>
<!-- IF ORDERCOL eq 'ends' -->
			<a href="yourauctions_sold.php?solda_ord=ends&solda_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
		</td>
		<td class="titTable1" width="10%" align="center">
			<a href="yourauctions_sold.php?solda_ord=num_bids&solda_type={ORDERNEXT}">{L_627}</a>
<!-- IF ORDERCOL eq 'num_bids' -->
			<a href="yourauctions_sold.php?solda_ord=num_bids&solda_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
		</td>
		<td class="titTable1" width="11%" align="center">
			<a href="yourauctions_sold.php?solda_ord=current_bid&solda_type={ORDERNEXT}">{L_628}</a>
<!-- IF ORDERCOL eq 'current_bid' -->
			<a href="yourauctions_sold.php?solda_ord=current_bid&solda_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
		</td>
		<td class="titTable1" width="10%" align="center">
			{L_630}
		</td>
	</tr>
<!-- BEGIN items -->
	<tr bgcolor="{items.BGCOLOUR}">
		<td width="40%">
			<a href="item.php?id={items.ID}">{items.TITLE}</a>
		</td>
		<td width="10%">
			{items.STARTS}
		</td>
		<td width="10%">
			{items.ENDS}
		</td>
		<td width="10%"  align="center">
			{items.BIDS}
		</td>
		<td width="11%"  align="center">
	<!-- IF items.B_HASNOBIDS -->
			-
	<!-- ELSE -->
			{items.BID}
	<!-- ENDIF -->
		</td>
		<td width="10%"  align="center">
	<!-- IF items.B_CLOSED -->
		<!-- IF items.B_RELIST -->
			<input type="checkbox" name="relist[]" value="{items.ID}" class="relistid">
		<!-- ELSE -->
			<a href="sellsimilar.php?id={items.ID}">{L_2__0050}</a>
		<!-- ENDIF -->
	<!-- ELSE -->
			{L_203}
	<!-- ENDIF -->
		</td>
	</tr>
<!-- END items -->
    <tr>
		<td colspan="6">&nbsp;</td>
	</tr>
    <tr>
        <td colspan="6" align="center">
            <input type="hidden" name="action" value="update">
            <input type="submit" name="Submit" value="{L_631}" class="button">
        </td>
    </tr>
</table>
</form>

<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td align="center">
			{L_5117}&nbsp;&nbsp;{PAGE}
			{L_5118}&nbsp;&nbsp;{PAGES}
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