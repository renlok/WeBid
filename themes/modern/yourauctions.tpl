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
	<ul class="nav nav-tabs nav-justified">
		<li role="presentation"><a href="yourauctions_p.php">{L_25_0115}</a></li>
		<li role="presentation" class="active"><a href="yourauctions.php">{L_619}</a></li>
		<li role="presentation"><a href="yourauctions_c.php">{L_204}</a></li>
		<li role="presentation"><a href="yourauctions_s.php">{L_2__0056}</a></li>
		<li role="presentation"><a href="yourauctions_sold.php">{L_25_0119}</a></li>
	</ul>
	<table class="table table-bordered table-condensed table-striped">
		<tr>
			<td width="32%">
				<a href="yourauctions.php?oa_ord=title&oa_type={ORDERNEXT}">{L_624}</a>
<!-- IF ORDERCOL eq 'title' -->
				<a href="yourauctions.php?oa_ord=title&oa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
			</td>
			<td class="hidden-xs" width="11%">
				<a href="yourauctions.php?oa_ord=starts&oa_type={ORDERNEXT}">{L_625}</a>
<!-- IF ORDERCOL eq 'starts' -->
				<a href="yourauctions.php?oa_ord=starts&oa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
			</td>
			<td width="11%">
				<a href="yourauctions.php?oa_ord=ends&oa_type={ORDERNEXT}">{L_626}</a>
<!-- IF ORDERCOL eq 'ends' -->
				<a href="yourauctions.php?oa_ord=ends&oa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
			</td>
			<td class="hidden-xs" align="center" nowrap="nowrap">
				{L__0153}
			</td>
			<td class="hidden-xs" width="7%" align="center">
				<a href="yourauctions.php?oa_ord=num_bids&oa_type={ORDERNEXT}">{L_627}</a>
<!-- IF ORDERCOL eq 'num_bids' -->
				<a href="yourauctions.php?oa_ord=num_bids&oa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
			</td>
			<td width="10%" align="center">
				<a href="yourauctions.php?oa_ord=current_bid&oa_type={ORDERNEXT}">{L_116}</a>
<!-- IF ORDERCOL eq 'current_bid' -->
				<a href="yourauctions.php?oa_ord=current_bid&oa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
<!-- ENDIF -->
			</td>
			<td width="6%" align="center">
				{L_298}
			</td>
			<td width="8%" align="center">
				{L_008}
			</td>
			<td width="6%" align="center" bgcolor="#FFFF00">
				{L_2__0048}
			</td>
		</tr>
<!-- IF B_AREITEMS -->
	<!-- BEGIN items -->
		<tr bgcolor="#EEEEEE">
			<td width="32%">
				<a href="item.php?id={items.ID}">{items.TITLE}</a>
				<br>
				<small>[{L_30_0081}{items.COUNTER}{L__0151}]</small></td>
			<td class="hidden-xs" width="11%" align="center">
				<small>{items.STARTS}</small>
			</td>
			<td width="11%" align="center">
				<small>{items.ENDS}</small>
			</td>
			<td class="hidden-xs" width="9%"  align="center">
		<!-- IF items.RELISTED eq 0 -->
				0
		<!-- ELSE -->
				{items.RELISTED}
		<!-- ENDIF -->
			</td>
			<td class="hidden-xs" width="7%"  align="center">
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
				<a href="edit_active_auction.php?id={items.ID}"><span class="glyphicon glyphicon-edit" aria-hidden="true" title="{L_click_to_edit_auction}"></span></a>
		<!-- ELSE -->
				<span class="glyphicon glyphicon-info-sign" aria-hidden="true" title="{L_edit_disabled}"></span>
		<!-- ENDIF -->
			</td>
			<td width="8%"  align="center">
		<!-- IF items.B_HASNOBIDS -->
				<input type="checkbox" name="O_delete[]" value="{items.ID}">
		<!-- ELSE -->
				<span class="glyphicon glyphicon-info-sign" aria-hidden="true" title="{L_delete_auction_disabled}"></span>		
		<!-- ENDIF -->
			</td>
			<td width="6%"  align="center" bgcolor="#FFFFaa">
				<input type="checkbox" name="closenow[]" value="{items.ID}">
			</td>
		</tr>
	<!-- END items -->
<!-- ENDIF -->
		<tr class="hidden-xs" {BGCOLOUR}>
			<td colspan="7" align="right">{L_30_0102}</td>
			<td align="center"><input type="checkbox" id="deleteall"></td>
			<td align="center"><input type="checkbox" id="closeall"></td>
		</tr>
		<tr>
			<td colspan="9" align="center">
				<input type="hidden" name="action" value="delopenauctions">
				<input type="submit" name="Submit" value="{L_631}" class="btn btn-primary">
			</td>
		</tr>
	</table>
</form>
<div class="text-center">
	{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
	<br>
	{PREV}
<!-- BEGIN pages -->
	{pages.PAGE}&nbsp;&nbsp;
<!-- END pages -->
	{NEXT}
</div>

<!-- INCLUDE user_menu_footer.tpl -->