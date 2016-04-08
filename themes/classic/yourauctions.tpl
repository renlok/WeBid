<!-- INCLUDE user_menu_header.tpl -->

<script type="text/javascript">
$(document).ready(function() {
	$("#closeall").click(function() {
		var checked_status = this.checked;
		$("input[name='closenow[]']").each(function() {
			this.checked = checked_status;
		});
	});
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
<form name="auctions" method="post" action="" id="processdel">
	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
	<dl class="tabs">
		<dd class="active"><a href="yourauctions.php">{L_619}</a></dd>
		<dd><a href="yourauctions_p.php">{L_25_0115}</a></dd>
		<dd><a href="yourauctions_c.php">{L_204}</a></dd>
		<dd><a href="yourauctions_s.php">{L_2__0056}</a></dd>
		<dd><a href="yourauctions_sold.php">{L_25_0119}</a></dd>
	</dl>
	<table width="100%" border="0" cellspacing="1" cellpadding="4" align="CENTER">
		<tr>
			<td class="titTable1" width="32%">
				<a href="yourauctions.php?oa_ord=title&oa_type={ORDERNEXT}">{L_624}</a>
<!-- IF ORDERCOL eq 'title' -->
				<a href="yourauctions.php?oa_ord=title&oa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
			</td>
			<td class="titTable1" width="11%">
				<a href="yourauctions.php?oa_ord=starts&oa_type={ORDERNEXT}">{L_625}</a>
<!-- IF ORDERCOL eq 'starts' -->
				<a href="yourauctions.php?oa_ord=starts&oa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
			</td>
			<td class="titTable1" width="11%">
				<a href="yourauctions.php?oa_ord=ends&oa_type={ORDERNEXT}">{L_626}</a>
<!-- IF ORDERCOL eq 'ends' -->
				<a href="yourauctions.php?oa_ord=ends&oa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
			</td>
			<td class="titTable1" align="center" nowrap="nowrap">
				{L__0153}
			</td>
			<td class="titTable1" width="7%" align="center">
				<a href="yourauctions.php?oa_ord=num_bids&oa_type={ORDERNEXT}">{L_627}</a>
<!-- IF ORDERCOL eq 'num_bids' -->
				<a href="yourauctions.php?oa_ord=num_bids&oa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
			</td>
			<td class="titTable1" width="10%" align="center">
				<a href="yourauctions.php?oa_ord=current_bid&oa_type={ORDERNEXT}">{L_116}</a>
<!-- IF ORDERCOL eq 'current_bid' -->
				<a href="yourauctions.php?oa_ord=current_bid&oa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
			</td>
			<td class="titTable1" width="6%" align="center">
				{L_298}
			</td>
			<td class="titTable1" width="8%" align="center">
				{L_008}
			</td>
			<td class="titTable1" width="6%" align="center" bgcolor="#FFFF00">
				{L_2__0048}
			</td>
		</tr>
<!-- IF B_AREITEMS -->
	<!-- BEGIN items -->
		<tr bgcolor="#EEEEEE">
			<td width="32%">
				<a href="item.php?id={items.ID}">{items.TITLE}</a>
				<br>
				[{L_30_0081}{items.COUNTER}{L__0151}]</td>
			<td width="11%" align="center">
				{items.STARTS}
			</td>
			<td width="11%" align="center">
				{items.ENDS}
			</td>
			<td width="9%"  align="center">
		<!-- IF items.RELISTED eq 0 -->
				0
		<!-- ELSE -->
				{items.RELISTED}
		<!-- ENDIF -->
			</td>
			<td width="7%"  align="center">
				{items.BIDS}
			</td>
			<td width="10%"  align="center">
		<!-- IF items.B_HASNOBIDS -->
				{L_no_bids}
		<!-- ELSE -->
				{items.BID}
		<!-- ENDIF -->
			</td>
			<td width="6%"  align="center">
		<!-- IF items.B_HASNOBIDS -->
				<a href="edit_active_auction.php?id={items.ID}" title="{L_click_to_edit_auction}"><img src="images/edititem.gif" width="13" height="17" alt="{L_512}" border="0"></a>
		<!-- ELSE -->
				<img src="images/info.gif" title="{L_edit_disabled}" width="13" height="13" alt="{L_512}" border="0">
		<!-- ENDIF -->
			</td>
			<td width="8%"  align="center">
		<!-- IF items.B_HASNOBIDS -->
				<input type="checkbox" name="O_delete[]" value="{items.ID}">
		<!-- ELSE -->
				<img src="images/info.gif" title="{L_delete_auction_disabled}" width="13" height="13" alt="{L_512}" border="0">
		<!-- ENDIF -->
			</td>
			<td width="6%"  align="center" bgcolor="#FFFFaa">
				<input type="checkbox" name="closenow[]" value="{items.ID}">
			</td>
		</tr>
	<!-- END items -->
<!-- ENDIF -->
		<tr {BGCOLOUR}>
			<td colspan="7" align="right">{L_30_0102}</td>
			<td align="center"><input type="checkbox" id="deleteall"></td>
			<td align="center"><input type="checkbox" id="closeall"></td>
		</tr>
		<tr>
			<td colspan="9" align="center">
				<input type="hidden" name="action" value="delopenauctions">
				<input type="submit" name="Submit" value="{L_631}" class="button">
			</td>
		</tr>
	</table>
</form>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
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
