<!-- INCLUDE user_menu_header.tpl -->

<script type="text/javascript">
$(document).ready(function() {
	$("#closeall").click(function() {
		$("input[@class=closenow]").each(function() {
			if (this.checked) {
				this.checked = false;
			} else {
				this.checked = true;
			}
		});
		return false;
	});
	$("#deleteall").click(function() {
		$("input[@class=O_delete]").each(function() {
			if (this.checked) {
				this.checked = false;
			} else {
				this.checked = true;
			}
		});
		return false;
	});
	$("#processdel").submit(function() {
		if (confirm('{L_30_0087}')){
			return true;
		} else {
			return false;
		}
	});
});
</script>
<form name="auctions" method="post" action="" id="processdel">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td colspan="9" align="right">
			<dl class="tabs">
				<dd><a href="yourauctions_p.php">{L_25_0115}</a></dd>
				<dd><a href="yourauctions_c.php">{L_204}</a></dd>
				<dd><a href="yourauctions_s.php">{L_2__0056}</a></dd>
				<dd><a href="yourauctions_sold.php">{L_25_0119}</a></dd>
			</dl>
		</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="4" align="CENTER">
<tr bgcolor="{TBLHEADERCOLOUR}">
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
			<a href="yourauctions.php?oa_ord=current_bid&oa_type={ORDERNEXT}">{L_628}</a>
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
		<td width="11%">
			{items.STARTS}
		</td>
		<td width="11%">
			{items.ENDS}
		</td>
		<td width="9%"  align="center">
		<!-- IF items.RELISTED eq 0 -->
			--
		<!-- ELSE -->
			{items.RELISTED}
		<!-- ENDIF -->
		</td>
		<td width="7%"  align="center">
			{items.BIDS}
		</td>
		<td width="10%"  align="center">
		<!-- IF items.B_HASNOBIDS -->
			-
		<!-- ELSE -->
			{items.BID}<br>[{L_159} <a href="profile.php?user_id={items.BIDDERID}">{items.BIDDER}</a>]
		<!-- ENDIF -->
		</td>
		<td width="6%"  align="center">
		<!-- IF items.B_HASNOBIDS -->
			<a href="edit_active_auction.php?id={items.ID}"><img src="images/edititem.gif" width="13" height="17" alt="{L_512}" border="0"></a>
		<!-- ENDIF -->
		</td>
		<td width="8%"  align="center">
		<!-- IF items.B_HASNOBIDS -->
			<input type="checkbox" name="O_delete[]" value="{items.ID}" class="O_delete">
		<!-- ENDIF -->
		</td>
		<td width="6%"  align="center" bgcolor="#FFFFaa">
			<input type="checkbox" name="closenow[]" value="{items.ID}" class="closenow">
		</td>
	</tr>
	<!-- END items -->
<!-- ENDIF -->
	<tr bgcolor="{BGCOLOUR}">
		<td colspan="7">&nbsp;</td>
		<td align="center"><a href="#" id="deleteall">{L_30_0102}</a></td>
		<td align="center"><a href="#" id="closeall">{L_30_0102}</a></td>
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